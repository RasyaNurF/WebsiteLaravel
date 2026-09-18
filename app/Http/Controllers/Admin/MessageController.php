<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MessageReplyRequest;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $participants = ChatParticipant::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->withCount('messages')
            ->with('messages')
            ->orderByDesc('last_message_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Pesan'],
            ],
            'searchPlaceholder' => 'Cari nama, email, atau subjek…',
            'searchAction' => route('admin.messages.index'),
            'participants' => $participants,
            'statuses' => MessageStatus::cases(),
        ]);
    }

    public function show(ChatParticipant $participant): View
    {
        $messages = $participant->messages()->oldest()->get();

        if ($participant->status === MessageStatus::Unread->value) {
            $participant->update(['status' => MessageStatus::Read->value]);
            $participant->messages()->update(['is_read' => true]);
        }

        return view('admin.messages.show', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Pesan', 'url' => route('admin.messages.index')],
                ['label' => $participant->name],
            ],
            'participant' => $participant,
            'messages' => $messages,
            'statuses' => MessageStatus::cases(),
        ]);
    }

    public function reply(MessageReplyRequest $request, ChatParticipant $participant): RedirectResponse
    {
        ChatMessage::create([
            'chat_participant_id' => $participant->id,
            'guest_token' => $participant->guest_token,
            'sender' => 'admin',
            'name' => auth()->user()->name,
            'body' => $request->validated('body'),
            'is_read' => true,
        ]);

        $participant->update([
            'status' => MessageStatus::Replied->value,
            'last_message_at' => now(),
        ]);

        return redirect()->route('admin.messages.show', $participant)->with('success', 'Balasan berhasil dikirim.');
    }

    public function update(Request $request, ChatParticipant $participant): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(MessageStatus::class)],
        ]);

        $participant->update(['status' => $validated['status']]);

        return redirect()->route('admin.messages.show', $participant)->with('success', 'Status percakapan berhasil diperbarui.');
    }

    public function destroy(ChatParticipant $participant): RedirectResponse
    {
        $participant->messages()->delete();
        $participant->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Percakapan berhasil dihapus.');
    }
}
