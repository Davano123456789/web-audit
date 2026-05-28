<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CobitDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Populate Domains
        $domains = [
            [
                'id' => 'APO',
                'name' => 'Align, Plan and Organize',
                'description' => "management yang berfokus pada penyelarasan \r\nstrategi TI dengan tujuan bisnis organisasi. Domain ini mencakup proses \r\nmerencanakan, mengelola strategi teknologi informasi,",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'MEA',
                'name' => 'Monitor, Evaluate, and Assess',
                'description' => "management yang berfokus pada \r\npemantauan, evaluasi maupun penilaian terhadap kinerja dan kepatuhan TI \r\ndalam sebuah organisasi.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('cobit_domains')->insert($domains);

        // 2. Populate Processes
        $processes = [
            [
                'code' => 'APO08',
                'domain_id' => 'APO',
                'name' => 'Managed Relationships',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'MEA03',
                'domain_id' => 'MEA',
                'name' => 'Mengelola kepatuhan terhadap persyaratan eksternal',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('cobit_processes')->insert($processes);

        // 3. Populate Practices
        $practices = [
            [
                'code' => 'APO08.01',
                'process_code' => 'APO08',
                'name' => 'Memahami harapan bisnis',
                'description' => 'Memahami harapan bisnis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'APO08.02',
                'process_code' => 'APO08',
                'name' => 'Menyelaraskan ekspektasi, persyaratan, dan solusi',
                'description' => 'Menyelaraskan ekspektasi, persyaratan, dan solusi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'APO08.03',
                'process_code' => 'APO08',
                'name' => 'Mengelola hubungan bisnis',
                'description' => 'Mengelola hubungan bisnis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'APO08.04',
                'process_code' => 'APO08',
                'name' => 'Mengoordinasikan dan melaporkan hubungan bisnis',
                'description' => 'Mengoordinasikan dan melaporkan hubungan bisnis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'APO08.05',
                'process_code' => 'APO08',
                'name' => 'Memberikan masukan untuk peningkatan berkelanjutan layanan',
                'description' => 'Memberikan masukan untuk peningkatan berkelanjutan layanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'MEA03.01',
                'process_code' => 'MEA03',
                'name' => 'Identifikasi persyaratan kepatuhan eksternal',
                'description' => 'Identifikasi persyaratan kepatuhan eksternal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'MEA03.02',
                'process_code' => 'MEA03',
                'name' => 'Mengoptimalkan respons terhadap persyaratan kepatuhan eksternal',
                'description' => 'Mengoptimalkan respons terhadap persyaratan kepatuhan eksternal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'MEA03.03',
                'process_code' => 'MEA03',
                'name' => 'Memperoleh jaminan kepatuhan eksternal',
                'description' => 'Memperoleh jaminan kepatuhan eksternal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'MEA03.04',
                'process_code' => 'MEA03',
                'name' => 'Memperoleh jaminan kepatuhan',
                'description' => 'Memperoleh jaminan kepatuhan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('cobit_practices')->insert($practices);

        // 4. Populate Questions (Level 2 - 5)
        $questions = [
            // ==================== APO08 QUESTIONS ====================
            // APO08.01 (Level 2)
            [
                'practice_code' => 'APO08.01',
                'level' => 2,
                'question_text' => 'Identifikasi pemangku kepentingan bisnis, kepentingan mereka, dan area tanggung jawabnya.',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.01',
                'level' => 2,
                'question_text' => 'Apakah organisasi melakukan tinjauan berkala terhadap arah kebijakan, isu-isu saat ini, tujuan strategis perusahaan, serta keselarasan dengan arsitektur perusahaan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.01',
                'level' => 2,
                'question_text' => 'Apakah organisasi mengidentifikasi dan memahami kondisi lingkungan bisnis saat ini, hambatan proses, rencana ekspansi/penyusutan wilayah operasional, serta faktor regulasi industri?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.01',
                'level' => 2,
                'question_text' => 'Apakah organisasi memantau aktivitas proses bisnis secara berkala serta memahami pola permintaan yang berkaitan dengan volume dan penggunaan layanan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // APO08.01 (Level 3)
            [
                'practice_code' => 'APO08.01',
                'level' => 3,
                'question_text' => 'Apakah organisasi mengelola ekspektasi dengan memastikan bahwa setiap unit bisnis memahami prioritas, ketergantungan (dependencies), batasan finansial, serta kebutuhan untuk penjadwalan permintaan layanan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // APO08.01 (Level 4)
            [
                'practice_code' => 'APO08.01',
                'level' => 4,
                'question_text' => 'Apakah organisasi memperjelas ekspektasi bisnis terhadap solusi dan layanan berbasis teknologi informasi, serta memastikan kebutuhan didefinisikan bersama kriteria keberterimaan bisnis dan metrik terkait?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.01',
                'level' => 4,
                'question_text' => 'Apakah organisasi memastikan adanya kesepakatan tertulis antara divisi TI dan seluruh departemen bisnis mengenai ekspektasi beserta metode pengukurannya, serta memastikan kesepakatan tersebut dikonfirmasi oleh seluruh pemangku kepentingan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // APO08.02 (Level 3)
            [
                'practice_code' => 'APO08.02',
                'level' => 3,
                'question_text' => 'Apakah divisi TI memosisikan diri sebagai mitra bagi unit bisnis dengan berperan proaktif dalam mengidentifikasi dan mengomunikasikan peluang, risiko, serta batasan terkait teknologi terkini, layanan, maupun model proses bisnis kepada pemangku kepentingan utama?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.02',
                'level' => 3,
                'question_text' => 'Apakah organisasi memastikan keterlibatan divisi TI sejak awal inisiatif baru utama melalui kolaborasi dengan manajemen portofolio, program, dan proyek, guna memberikan saran bernilai tambah (seperti pengembangan business case, analisis kebutuhan, desain solusi) serta mengambil tanggung jawab penuh atas alur kerja TI?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // APO08.03 (Level 3)
            [
                'practice_code' => 'APO08.03',
                'level' => 3,
                'question_text' => 'Apakah organisasi menunjuk seorang Relationship Manager sebagai narahubung tunggal untuk setiap unit bisnis utama, serta memastikan perwakilan dari unit bisnis tersebut memiliki pemahaman bisnis, wawasan teknologi, dan tingkat otoritas yang memadai?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.03',
                'level' => 3,
                'question_text' => 'Apakah organisasi mengelola hubungan kemitraan secara formal dan transparan untuk memastikan fokus bersama dalam mendukung tujuan strategis perusahaan, dengan tetap memperhatikan batasan anggaran dan toleransi risiko?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.03',
                'level' => 3,
                'question_text' => 'Apakah organisasi menetapkan dan mengomunikasikan prosedur penanganan keluhan dan eskalasi untuk menyelesaikan setiap permasalahan hubungan kerja sama?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.03',
                'level' => 3,
                'question_text' => 'Apakah organisasi memastikan setiap keputusan penting disetujui dan disahkan secara formal oleh pemangku kepentingan terkait yang bertanggung jawab (accountable)?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // APO08.03 (Level 4)
            [
                'practice_code' => 'APO08.03',
                'level' => 4,
                'question_text' => 'Apakah organisasi merencanakan interaksi dan jadwal pertemuan spesifik berdasarkan tujuan yang disepakati bersama (seperti rapat tinjauan kinerja layanan, pembahasan rencana strategis baru, dll.)?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // APO08.04 (Level 2)
            [
                'practice_code' => 'APO08.04',
                'level' => 2,
                'question_text' => 'Apakah organisasi mengoordinasikan dan mengomunikasikan rencana perubahan dan aktivitas transisi (seperti jadwal proyek, kebijakan rilis, pemberitahuan kesalahan rilis yang diketahui/known errors, serta sosialisasi pelatihan)?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.04',
                'level' => 2,
                'question_text' => 'Apakah organisasi mengoordinasikan dan mengomunikasikan aktivitas operasional serta pembagian peran/tanggung jawab (termasuk definisi jenis permintaan layanan, eskalasi berjenjang, pemadaman sistem utama, dan frekuensi laporan layanan)?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.04',
                'level' => 2,
                'question_text' => 'Apakah divisi TI mengambil tanggung jawab penuh atas penyediaan respons/tanggapan kepada unit bisnis ketika terjadi insiden/peristiwa besar yang memengaruhi hubungan kemitraan, serta memberikan dukungan langsung jika diperlukan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // APO08.04 (Level 3)
            [
                'practice_code' => 'APO08.04',
                'level' => 3,
                'question_text' => 'Apakah organisasi memiliki dan memelihara rencana komunikasi menyeluruh (end-to-end) yang mendefinisikan isi, frekuensi, dan penerima informasi kinerja layanan (termasuk status realisasi nilai manfaat dan risiko yang teridentifikasi)?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // APO08.05 (Level 4)
            [
                'practice_code' => 'APO08.05',
                'level' => 4,
                'question_text' => 'Apakah organisasi melakukan analisis kepuasan terhadap pengguna (customer) dan penyedia layanan (provider), memastikan setiap keluhan ditindaklanjuti, serta melaporkan hasil dan status penyelesaiannya?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // APO08.05 (Level 5)
            [
                'practice_code' => 'APO08.05',
                'level' => 5,
                'question_text' => 'Apakah seluruh pihak terkait bekerja sama secara kolaboratif untuk mengidentifikasi, mengomunikasikan, serta menerapkan inisiatif peningkatan (improvement) kualitas layanan secara berkelanjutan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'APO08.05',
                'level' => 5,
                'question_text' => 'Apakah divisi TI bekerja sama dengan manajemen layanan (service management) and pemilik proses (process owners) untuk memastikan layanan berbasis TI beserta proses pengelolaannya terus ditingkatkan secara berkelanjutan, serta akar penyebab masalah diidentifikasi dan diselesaikan secara tuntas?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ==================== MEA03 QUESTIONS ====================
            // MEA03.01 (Level 2)
            [
                'practice_code' => 'MEA03.01',
                'level' => 2,
                'question_text' => 'Apakah organisasi menetapkan tanggung jawab khusus untuk mengidentifikasi dan memantau perubahan hukum, regulasi, dan kewajiban kontrak eksternal yang relevan dengan penggunaan sumber daya TI serta pemrosesan informasi perusahaan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.01',
                'level' => 2,
                'question_text' => 'Apakah organisasi mengidentifikasi serta menilai seluruh potensi persyaratan kepatuhan dan dampaknya terhadap aktivitas TI (seperti aliran data, privasi, kontrol internal, pelaporan keuangan, hak kekayaan intelektual, dan regulasi khusus industri)?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.01',
                'level' => 2,
                'question_text' => 'Apakah organisasi menilai dampak dari persyaratan hukum dan regulasi terkait TI terhadap kontrak dengan pihak ketiga (seperti penyedia layanan operasional TI dan mitra bisnis)?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.01',
                'level' => 2,
                'question_text' => 'Apakah organisasi menetapkan secara jelas konsekuensi atau sanksi akibat ketidakpatuhan terhadap hukum, regulasi, dan persyaratan kontrak eksternal?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // MEA03.01 (Level 3)
            [
                'practice_code' => 'MEA03.01',
                'level' => 3,
                'question_text' => 'Apakah organisasi melibatkan penasihat hukum independen atau tenaga ahli eksternal ketika menganalisis dampak dari perubahan undang-undang, regulasi, maupun standar industri yang berlaku?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.01',
                'level' => 3,
                'question_text' => 'Apakah organisasi mencatat dan memelihara log pemantauan hukum, regulasi, serta persyaratan kontrak eksternal secara mutakhir, lengkap dengan dampak dan tindakan perbaikan yang diperlukan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.01',
                'level' => 3,
                'question_text' => 'Apakah organisasi memelihara daftar (register) kepatuhan eksternal secara terintegrasi dan selaras di seluruh tingkat perusahaan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // MEA03.02 (Level 3)
            [
                'practice_code' => 'MEA03.02',
                'level' => 3,
                'question_text' => 'Apakah organisasi secara berkala meninjau dan menyesuaikan kebijakan, prinsip, standar, serta prosedur TI guna memastikan efektivitas pemenuhan kepatuhan eksternal dan meminimalkan risiko bisnis, dengan melibatkan tenaga ahli jika diperlukan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.02',
                'level' => 3,
                'question_text' => 'Apakah organisasi mengomunikasikan setiap adanya persyaratan kepatuhan baru maupun perubahan regulasi eksternal secara formal kepada seluruh personel terkait?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // MEA03.03 (Level 3)
            [
                'practice_code' => 'MEA03.03',
                'level' => 3,
                'question_text' => 'Apakah organisasi secara rutin mengevaluasi kebijakan, standar, serta prosedur di seluruh fungsi unit bisnis untuk memastikan kepatuhan terhadap persyaratan hukum dan regulasi terkait pemrosesan informasi?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.03',
                'level' => 3,
                'question_text' => 'Apakah organisasi menindaklanjuti dan mengatasi kesenjangan (gaps) kepatuhan dalam kebijakan, standar, serta prosedur secara tepat waktu?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.03',
                'level' => 3,
                'question_text' => 'Apakah organisasi secara periodik mengevaluasi aktivitas bisnis dan proses TI guna memastikan kepatuhan terhadap persyaratan hukum, regulasi, serta kewajiban kontrak yang berlaku?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // MEA03.03 (Level 4)
            [
                'practice_code' => 'MEA03.03',
                'level' => 4,
                'question_text' => 'Apakah organisasi meninjau secara berkala pola kegagalan kepatuhan yang berulang (recurring failures) dan mendokumentasikan pelajaran yang dipetik (lessons learned)?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // MEA03.03 (Level 5)
            [
                'practice_code' => 'MEA03.03',
                'level' => 5,
                'question_text' => 'Apakah organisasi melakukan perbaikan berkelanjutan terhadap kebijakan, standar, prosedur, serta aktivitas terkait berdasarkan hasil evaluasi dan dokumentasi lessons learned?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // MEA03.04 (Level 2)
            [
                'practice_code' => 'MEA03.04',
                'level' => 2,
                'question_text' => 'Apakah organisasi memperoleh konfirmasi berkala mengenai kepatuhan terhadap kebijakan internal dari pemilik proses bisnis/TI serta kepala unit kerja?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.04',
                'level' => 2,
                'question_text' => 'Apakah organisasi melakukan tinjauan internal dan eksternal secara berkala (dan secara independen jika diperlukan) untuk menilai tingkat kepatuhan eksternal?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.04',
                'level' => 2,
                'question_text' => 'Apakah organisasi memperoleh surat pernyataan (assertions) atau jaminan dari penyedia layanan TI pihak ketiga mengenai tingkat kepatuhan mereka terhadap hukum dan regulasi yang berlaku?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'practice_code' => 'MEA03.04',
                'level' => 2,
                'question_text' => 'Apakah organisasi memperoleh jaminan tertulis dari mitra bisnis mengenai tingkat kepatuhan mereka terhadap hukum dan regulasi terkait transaksi elektronik antarkeperusahaan?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // MEA03.04 (Level 3)
            [
                'practice_code' => 'MEA03.04',
                'level' => 3,
                'question_text' => 'Apakah organisasi mengintegrasikan pelaporan mengenai pemenuhan persyaratan hukum, regulasi, dan kontrak eksternal di seluruh tingkat perusahaan dengan melibatkan seluruh unit bisnis?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // MEA03.04 (Level 4)
            [
                'practice_code' => 'MEA03.04',
                'level' => 4,
                'question_text' => 'Apakah organisasi memantau serta melaporkan setiap kasus ketidakpatuhan yang terjadi, dan menyelidiki akar penyebabnya (root cause) untuk tindakan korektif?',
                'expected_evidence' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('cobit_questions')->insert($questions);
    }
}
