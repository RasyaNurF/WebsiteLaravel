<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(Request $request): View
    {
        $token = $this->guestToken($request);

        $messages = ChatMessage::query()
            ->where('guest_token', $token)
            ->oldest()
            ->get();

        return view('contact', ['messages' => $messages]);
    }

    public function store(Request $request): JsonResponse
    {
        $needsIdentity = ! $request->session()->has('chat_name');

        $validated = $request->validate([
            'name' => $needsIdentity
                ? ['required', 'string', 'max:100']
                : ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $token = $this->guestToken($request);
        $name = $validated['name'] ?? $request->session()->get('chat_name');

        if (filled($validated['name'] ?? null)) {
            $request->session()->put('chat_name', $validated['name']);
        }

        if (filled($validated['email'] ?? null)) {
            $request->session()->put('chat_email', $validated['email']);
        }

        $guestMessage = ChatMessage::create([
            'guest_token' => $token,
            'sender' => 'guest',
            'name' => $name,
            'email' => $validated['email'] ?? $request->session()->get('chat_email'),
            'body' => $validated['body'],
        ]);

        $autoReply = ChatMessage::create([
            'guest_token' => $token,
            'sender' => 'admin',
            'name' => 'Admin Nusakode',
            'body' => "Terima kasih {$name}! Pesan Anda sudah kami terima dan akan ditindaklanjuti maksimal 1x24 jam kerja. Silakan lanjutkan chat bila ada tambahan.",
            'is_auto' => true,
        ]);

        return response()->json([
            'messages' => collect([$guestMessage, $autoReply])
                ->map(fn (ChatMessage $message): array => $this->present($message))
                ->values(),
        ]);
    }

    private function guestToken(Request $request): string
    {
        return $request->session()->get('chat_token') ?? tap(
            Str::uuid()->toString(),
            fn (string $token) => $request->session()->put('chat_token', $token)
        );
    }

    private function present(ChatMessage $message): array
    {
        return [
            'sender' => $message->sender,
            'name' => $message->name,
            'body' => $message->body,
            'is_auto' => $message->is_auto,
            'time' => $message->created_at->format('H:i'),
        ];
    }
}
