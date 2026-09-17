<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectInquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_a_project_inquiry(): void
    {
        $response = $this->post(route('kontak.permintaan'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@perusahaan.co.id',
            'company' => 'PT Sinar Niaga',
            'project_type' => 'Sistem Informasi / ERP',
            'budget_range' => 'Rp 50 – 150 juta',
            'project_detail' => 'Kami membutuhkan sistem inventaris multi-cabang dengan laporan bulanan.',
        ]);

        $response->assertRedirect(route('kontak').'#proyek');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('project_inquiries', [
            'name' => 'Budi Santoso',
            'email' => 'budi@perusahaan.co.id',
            'project_type' => 'Sistem Informasi / ERP',
        ]);
    }

    public function test_project_inquiry_requires_name_email_type_and_detail(): void
    {
        $response = $this->post(route('kontak.permintaan'), []);

        $response->assertSessionHasErrors(['name', 'email', 'project_type', 'project_detail']);
        $this->assertDatabaseCount('project_inquiries', 0);
    }

    public function test_project_inquiry_rejects_unknown_type_and_budget(): void
    {
        $response = $this->post(route('kontak.permintaan'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@perusahaan.co.id',
            'project_type' => 'Terbang ke bulan',
            'budget_range' => 'Seikhlasnya',
            'project_detail' => 'Detail proyek yang valid.',
        ]);

        $response->assertSessionHasErrors(['project_type', 'budget_range']);
        $this->assertDatabaseCount('project_inquiries', 0);
    }
}
