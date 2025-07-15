<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;

class FixMentorNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user dengan role pembimbing
        $mentors = User::where('role', 'pembimbing')->get();
        
        foreach ($mentors as $mentor) {
            // Cari divisi yang terkait
            $divisi = Divisi::find($mentor->divisi_id);
            
            if ($divisi) {
                // Update nama pembimbing sesuai dengan pic_name divisi
                $mentor->update([
                    'name' => $divisi->pic_name
                ]);
                
                $this->command->info("Updated mentor {$mentor->username} name from '{$mentor->getOriginal('name')}' to '{$divisi->pic_name}'");
            } else {
                $this->command->warn("Mentor {$mentor->username} has no associated divisi (divisi_id: {$mentor->divisi_id})");
            }
        }
        
        $this->command->info('Mentor names update completed!');
    }
}