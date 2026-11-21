<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $userId = $user ? $user->id : null;

        $posts = [
            [
                'title' => 'Panduan Memilih Bahan Huruf Timbul: Stainless, Akrilik, atau Galvanis?',
                'slug' => 'panduan-memilih-bahan-huruf-timbul-stainless-akrilik-galvanis',
                'summary' => 'Panduan komprehensif menentukan bahan huruf timbul terbaik sesuai kebutuhan lokasi toko, ketahanan cuaca di Jawa Timur, dan estetika bisnis Anda.',
                'content' => '<p>Memilih material signage luar ruang merupakan keputusan investasi jangka panjang bagi citra visual tempat usaha Anda. Di Sonar Advertising, tiga bahan huruf timbul yang paling sering digunakan adalah stainless steel, akrilik, dan plat galvanis.</p><h3>1. Huruf Timbul Stainless Steel</h3><p>Stainless steel menawarkan kesan mewah, profesional, dan eksklusif. Tersedia dalam pilihan finishing mirror (mengkilap seperti cermin) dan hairline (garis serat halus). Sangat cocok untuk kantor instansi, klinik estetika, dan logo perusahaan formal karena anti karat dan tahan paparan hujan asam.</p><h3>2. Huruf Timbul Akrilik LED</h3><p>Akrilik sangat unggul dalam fleksibilitas warna dan transmisi cahaya. Dipadukan dengan modul LED Samsung/Epistar hemat energi, huruf timbul akrilik mampu menyala terang merata di malam hari baik dengan teknik frontlit (cahaya depan) maupun backlit (pendaran cahaya di balik huruf).</p><h3>3. Huruf Timbul Galvanis Cat Duco</h3><p>Bagi bisnis yang memerlukan warna signage solid sesuai panduan identitas brand (misalnya kuning, hijau tosca, atau oranye), plat galvanis dengan finishing cat duco mobil dan lapisan clear coat anti gores adalah opsi paling ekonomis dengan struktur fisik yang sangat kokoh.</p>',
                'thumbnail' => '/storage/uploads/blog/blog-1.webp',
                'category' => 'Tips Material',
                'tags' => ['huruf timbul', 'stainless', 'akrilik', 'advertising jember', 'signage'],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-10-15 09:00:00'),
                'views' => 342,
            ],
            [
                'title' => 'Strategi Efektif Neon Box Akrilik LED untuk Menarik Pengunjung Cafe dan Retail',
                'slug' => 'strategi-efektif-neon-box-akrilik-led-cafe-toko-retail',
                'summary' => 'Mengapa visibilitas malam hari sangat menentukan foot traffic toko retail dan kafe, serta tips memilih modul LED hemat daya berkualitas tinggi.',
                'content' => '<p>Di kawasan komersial yang padat seperti pusat kota Jember dan Kediri, neon box adalah media promosi paling efektif untuk menarik perhatian calon pelanggan yang melintas di malam hari.</p><h3>Kunci Keberhasilan Desain Neon Box</h3><ul><li><strong>Kontras Tipografi:</strong> Gunakan font yang tegas dan tidak terlalu tipis agar nama usaha terbaca jelas dari jarak minimal 30 meter.</li><li><strong>Ketebalan Akrilik:</strong> Gunakan akrilik berkualitas dengan ketebalan 3mm agar tidak mudah melengkung akibat panas matahari siang hari.</li><li><strong>Pencahayaan Rata:</strong> Hindari bayangan titik lampu (hotspot) dengan mengatur jarak modul LED secara presisi di dalam box.</li></ul>',
                'thumbnail' => '/storage/uploads/blog/blog-2.webp',
                'category' => 'Desain & Branding',
                'tags' => ['neon box', 'kafe jember', 'led display', 'reklame'],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-10-22 10:30:00'),
                'views' => 289,
            ],
            [
                'title' => 'Prosedur dan Syarat Perizinan Reklame Outdoor & Billboard di Jember dan Kediri',
                'slug' => 'prosedur-syarat-perizinan-reklame-outdoor-jember-kediri',
                'summary' => 'Langkah-langkah resmi mengurus izin penyelenggaraan reklame, pajak reklame daerah (Bapenda), dan standar keamanan konstruksi billboard di Jawa Timur.',
                'content' => '<p>Pemasangan media promosi luar ruang di atas fasilitas umum atau di tepi jalan protokol wajib memiliki izin resmi demi keamanan dan ketertiban tata kota.</p><h3>Tahapan Pengurusan Izin Reklame</h3><ol><li><strong>Survei Titik Lokasi:</strong> Pastikan titik pemasangan tidak melanggar garis sempadan jalan (GSJ) atau utilitas kabel listrik PLN.</li><li><strong>Pengajuan Dokumen DPMPTSP:</strong> Siapkan denah lokasi, foto situasi eksisting, gambar teknis konstruksi rangka baja, dan naskah materi iklan.</li><li><strong>Penetapan Pajak Reklame (Bapenda):</strong> Perhitungan besaran pajak berdasarkan zona jalan, luas media, dan durasi penayangan reklame.</li><li><strong>Pemasangan Stiker Izin Resmi:</strong> Setelah retribusi lunas, plang stiker legalitas diterbitkan oleh dinas terkait.</li></ol>',
                'thumbnail' => '/storage/uploads/blog/blog-3.webp',
                'category' => 'Regulasi & Izin',
                'tags' => ['pajak reklame', 'izin billboard', 'advertising kediri', 'pemkab jember'],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-10-29 14:00:00'),
                'views' => 415,
            ],
            [
                'title' => 'Kelebihan Fasad ACP (Aluminium Composite Panel) untuk Modernisasi Bangunan Toko',
                'slug' => 'kelebihan-fasad-acp-aluminium-composite-panel-toko-kantor',
                'summary' => 'Ubah tampilan ruko atau kantor lama menjadi modern dan profesional dengan pelapisan ACP Seven / Alucobond tahan panas dan anti bocor.',
                'content' => '<p>Aluminium Composite Panel (ACP) telah menjadi standar arsitektur modern untuk gedung perkantoran, showroom dealer, dan ruko komersial. Bahan ini mampu menyamarkan dinding retak atau bangunan lama dalam waktu pengerjaan yang relatif singkat.</p><h3>Keunggulan Fasad ACP</h3><p>Tahan terhadap cuaca tropis, tidak berkarat, dan memiliki ketahanan warna hingga lebih dari 10 tahun (tipe PVDF eksterior). Permukaannya yang halus juga sangat ideal dipadukan dengan instalasi huruf timbul backlit LED sebagai pusat visual identitas gedung.</p>',
                'thumbnail' => '/storage/uploads/blog/blog-4.webp',
                'category' => 'Fasad & Konstruksi',
                'tags' => ['fasad acp', 'arsitektur ruko', 'konstruksi signage', 'modernisasi toko'],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-11-04 11:15:00'),
                'views' => 210,
            ],
            [
                'title' => 'Tips Perawatan Neon Flex Custom agar Awet dan Tetap Terang Bertahun-tahun',
                'slug' => 'tips-perawatan-neon-flex-custom-awet-terang',
                'summary' => 'Cara merawat instalasi neon flex interior kafe dan photobooth agar trafo stabil, silikon tidak menguning, dan cahaya LED tetap menyala rata.',
                'content' => '<p>Neon flex LED silikon 12V banyak dipilih pelaku usaha kuliner dan barbershop karena bentuknya yang artistik dan estetik untuk spot foto pengunjung.</p><h3>Panduan Perawatan Praktis</h3><ul><li><strong>Gunakan Power Supply Berkualitas:</strong> Trafo switching dengan kapasitas daya (watt) 20% lebih besar dari total beban neon flex mencegah panas berlebih (overheat).</li><li><strong>Bersihkan Permukaan Silikon Secara Berkala:</strong> Bersihkan debu halus dengan kain mikrofiber kering tanpa menggunakan zat pelarut keras seperti thinner.</li><li><strong>Hindari Kelembapan Berlebih:</strong> Pastikan soket sambungan kabel pada akrilik bening terlindung dari cipratan air atau tetesan AC.</li></ul>',
                'thumbnail' => '/storage/uploads/blog/blog-5.webp',
                'category' => 'Perawatan Signage',
                'tags' => ['neon flex', 'dekorasi kafe', 'perawatan led', 'tips branding'],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-11-10 13:45:00'),
                'views' => 178,
            ],
            [
                'title' => 'Membangun Identitas Visual Toko yang Menonjol di Kawasan Komersial Padat',
                'slug' => 'membangun-identitas-visual-toko-kawasan-komersial-padat',
                'summary' => 'Tips menentukan ukuran, sudut pandang (sightline), dan hierarki tipografi plang nama toko agar mudah dikenali pengendara jalan raya.',
                'content' => '<p>Ketika puluhan toko berjejer di sepanjang jalan protokol, bagaimana memastikan calon pembeli segera melihat dan mengingat toko Anda? Jawabannya terletak pada keselarasan sudut pandang (sightline) dan kontras visual signage.</p><h3>Rumus Keterbacaan Signage</h3><p>Terapkan rasio ketinggian huruf minimal 2,5 cm untuk setiap 10 meter jarak pandang. Pastikan plang nama memiliki sudut kemiringan yang tepat terhadap arus kendaraan dan hindari penempatan yang terhalang tiang listrik atau dahan pohon peneduh jalan.</p>',
                'thumbnail' => '/storage/uploads/blog/blog-6.webp',
                'category' => 'Strategi Bisnis',
                'tags' => ['identitas visual', 'plang nama', 'branding toko', 'advertising jawa timur'],
                'status' => 'published',
                'published_at' => Carbon::parse('2026-11-16 08:30:00'),
                'views' => 520,
            ]
        ];

        foreach ($posts as $postData) {
            BlogPost::updateOrCreate(
                ['slug' => $postData['slug']],
                array_merge($postData, ['user_id' => $userId])
            );
        }
    }
}
