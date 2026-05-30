<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Kerja - Proyek: {{ $project->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
            font-size: 11px;
            line-height: 1.5;
        }

        .header-container {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .header-container h1 {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 5px 0;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-container p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .meta-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .meta-table td.label {
            width: 150px;
            color: #64748b;
            font-weight: 600;
        }

        .meta-table td.value {
            color: #0f172a;
            font-weight: 700;
        }

        .section-title {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            margin: 30px 0 15px 0;
            text-transform: uppercase;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
            page-break-after: avoid;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .main-table th {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #475569;
            text-align: left;
        }

        .main-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center !important;
        }

        .font-bold {
            font-weight: 700;
        }

        /* Detail Process section styling */
        .process-container {
            margin-bottom: 35px;
            page-break-inside: auto;
        }

        .process-title {
            font-size: 12px;
            font-weight: 800;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            color: #0f172a;
            margin: 20px 0 10px 0;
            text-transform: uppercase;
            page-break-after: avoid;
        }

        .level-title {
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            margin: 15px 0 5px 0;
            padding-left: 5px;
            border-left: 3px solid #6366f1;
            page-break-after: avoid;
        }

        .practice-title {
            font-size: 11px;
            font-weight: 700;
            color: #1e293b;
            margin: 10px 0 5px 0;
            padding-left: 5px;
            page-break-after: avoid;
        }

        .question-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .question-table th {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 10px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            text-align: left;
        }

        .question-table td {
            border: 1px solid #e2e8f0;
            padding: 6px 10px;
            vertical-align: top;
            font-size: 10.5px;
        }

        .question-table td.question-text {
            width: 50%;
        }

        .question-table td.check-col {
            width: 10%;
            text-align: center;
            font-weight: 700;
        }

        .question-table td.evidence-col {
            width: 40%;
        }

        .evidence-rec {
            font-size: 9px;
            color: #64748b;
            background-color: #f8fafc;
            padding: 4px 8px;
            border-radius: 4px;
            margin-top: 5px;
            border: 1px dashed #e2e8f0;
        }

        /* Maturity Index Section at the end */
        .maturity-card {
            border: 2px solid #0f172a;
            border-radius: 8px;
            padding: 15px;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .maturity-card h3 {
            margin: 0 0 15px 0;
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .maturity-grid {
            display: table;
            width: 100%;
        }

        .maturity-row {
            display: table-row;
        }

        .maturity-label {
            display: table-cell;
            padding: 6px 0;
            font-weight: 700;
            color: #475569;
            width: 220px;
            font-size: 11px;
        }

        .maturity-value {
            display: table-cell;
            padding: 6px 0;
            font-weight: 700;
            color: #0f172a;
            font-size: 11px;
        }

        .maturity-desc {
            display: table-cell;
            padding: 6px 0;
            color: #334155;
            font-size: 11px;
            line-height: 1.5;
        }

        /* Print styles */
        @media print {
            body {
                padding: 0;
                margin: 1.5cm;
                font-size: 9.5px;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4;
                margin: 0;
            }

            /* Avoid page breaks inside tables and process block */
            .main-table, .question-table, .maturity-card {
                page-break-inside: avoid;
            }

            .process-container {
                page-break-inside: auto;
            }

            .process-title {
                page-break-after: avoid;
            }

            h1, h2, h3, h4 {
                page-break-after: avoid;
            }
        }

        /* Print button styling */
        .print-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .print-btn {
            background-color: #0f172a;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
        }

        .print-btn:hover {
            background-color: #1e293b;
        }
    </style>
</head>
<body>

    <!-- Print Action Button (Hidden on actual print) -->
    <div class="print-btn-container no-print">
        <button onclick="window.print()" class="print-btn">
            <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Lembar Kerja
        </button>
    </div>

    <!-- Header Section -->
    <div class="header-container">
        <h1>Lembar Kerja {{ $project->name }}</h1>
        <p>Audit Sistem Informasi berbasis COBIT 2019</p>
    </div>

    <!-- Project Metadata Details -->
    <table class="meta-table">
        <tr>
            <td class="label">Proyek</td>
            <td class="value">: {{ $project->name }}</td>
        </tr>
        <tr>
            <td class="label">Deskripsi</td>
            <td class="value">: {{ $project->description ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Asesor Pelaksana</td>
            <td class="value">: {{ $project->asesor->name }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Cetak</td>
            <td class="value">: {{ date('d F Y') }}</td>
        </tr>
    </table>

    <!-- Process Summary List Table -->
    <div class="section-title">Ringkasan Capaian Proses Assessment</div>
    <table class="main-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">No.</th>
                <th style="width: 150px;">Proses Assessment</th>
                <th>Deskripsi</th>
                <th class="text-center" style="width: 120px;">Level Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($project->projectProcesses as $index => $projectProcess)
                <tr>
                    <td class="text-center font-bold">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ $projectProcess->process_code }}</td>
                    <td>{{ $projectProcess->cobitProcess->name }}</td>
                    <td class="text-center font-bold">{{ $projectProcess->computed_capability_level ?: '0' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Detailed responses grouped by processes and capability levels -->
    <div class="section-title">Rincian Evaluasi Pertanyaan & Bukti Kerja</div>
    
    @php
        $responses = $project->responses->keyBy('question_id');
        
        $levelNames = [
            0 => 'Non-Existent',
            1 => 'Initial / Ad Hoc',
            2 => 'Repeatable but Intuitive',
            3 => 'Defined Process',
            4 => 'Managed and Measurable',
            5 => 'Optimized',
        ];
    @endphp

    @foreach($project->projectProcesses as $projectProcess)
        @php
            $practices = $projectProcess->cobitProcess->practices;
            $practiceCodes = $practices->pluck('code')->toArray();
        @endphp
        
        <div class="process-container">
            <div class="process-title">
                {{ $projectProcess->process_code }} — {{ $projectProcess->cobitProcess->name }}
            </div>

            @for($lvl = 2; $lvl <= 5; $lvl++)
                @php
                    $allLevelQuestions = \App\Models\CobitQuestion::whereIn('practice_code', $practiceCodes)
                        ->where('level', $lvl)
                        ->get();
                    
                    // Filter: only keep questions that have been answered
                    $levelQuestions = $allLevelQuestions->filter(function($q) use ($responses) {
                        return $responses->has($q->id);
                    });
                @endphp

                @if($levelQuestions->isNotEmpty())
                    <div class="level-title">Level {{ $lvl }}</div>

                    @php
                        $groupedQuestions = $levelQuestions->groupBy('practice_code');
                    @endphp

                    @foreach($groupedQuestions as $practiceCode => $qGroup)
                        @php
                            $practice = $practices->where('code', $practiceCode)->first();
                        @endphp
                        
                        <div class="practice-title">
                            {{ $practiceCode }} ({{ $practice->name ?? '' }})
                        </div>

                        <table class="question-table">
                            <thead>
                                <tr>
                                    <th class="question-text">Pertanyaan</th>
                                    <th class="check-col">Ada</th>
                                    <th class="evidence-col">Bukti Hasil Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($qGroup as $question)
                                    @php
                                        $res = $responses->get($question->id);
                                        $isAda = $res && in_array($res->answer, ['F', 'L']);
                                        $bukti = $res ? $res->notes : '';
                                        if ($res && $res->evidence_file) {
                                            $bukti .= ($bukti ? ' | ' : '') . 'File: ' . basename($res->evidence_file);
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <div>{{ $question->question_text }}</div>
                                            @if($question->expected_evidence)
                                                <div class="evidence-rec">
                                                    <strong>Rekomendasi Bukti:</strong> {{ $question->expected_evidence }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="check-col">{{ $isAda ? 'V' : '-' }}</td>
                                        <td>{{ $bukti ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                @endif
            @endfor
        </div>
    @endforeach

    <!-- Maturity Index Card Summary at the very end of printout -->
    <div class="maturity-card">
        <h3>Rekapitulasi Indeks Kematangan (Maturity Index)</h3>
        <div class="maturity-grid">
            <div class="maturity-row">
                <div class="maturity-label">Nilai Indeks Kematangan (Maturity Index)</div>
                <div class="maturity-value">: {{ $project->maturity_index ? number_format($project->maturity_index, 2) : '0.00' }} / 5.00</div>
            </div>
            <div class="maturity-row">
                <div class="maturity-label">Kesimpulan Level Kematangan</div>
                <div class="maturity-value">
                    : @if($project->maturity_index)
                        @if($project->maturity_index >= 4.51) Level 5 (Optimized)
                        @elseif($project->maturity_index >= 3.51) Level 4 (Managed)
                        @elseif($project->maturity_index >= 2.51) Level 3 (Defined)
                        @elseif($project->maturity_index >= 1.51) Level 2 (Repeatable)
                        @elseif($project->maturity_index >= 0.51) Level 1 (Initial)
                        @else Level 0 (Non-existent)
                        @endif
                    @else
                        Belum ada perhitungan skor final.
                    @endif
                </div>
            </div>
            @if($project->maturity_index)
                <div class="maturity-row">
                    <div class="maturity-label">Keterangan Hasil</div>
                    <div class="maturity-desc">
                        : @if($project->maturity_index >= 4.51)
                            Proses sudah berjalan secara optimal serta berfokus pada peningkatan yang berkelanjutan untuk meningkatkan kinerja proses.
                        @elseif($project->maturity_index >= 3.51)
                            Proses dikelola berdasarkan data dan pengukuran kinerja secara kuantitatif guna untuk meningkatkan efektifitas proses pada suatu organisasi.
                        @elseif($project->maturity_index >= 2.51)
                            Proses sudah memiliki standar dan pedoman yang jelas sehingga dapat diterapkan secara konsisten di seluruh organisasi.
                        @elseif($project->maturity_index >= 1.51)
                            Proses sudah direncanakan serta telah dilakukan pengukuran kinerja, namun belum memiliki standar yang baku pada seluruh organisasi.
                        @elseif($project->maturity_index >= 0.51)
                            Proses sudah dilakukan namun sebagian masih sederhana belum mampu mencapai tujuan Tata Kelola secara optimal.
                        @else
                            Proses belum berjalan dan dilaksanakan sepenuhnya dengan baik, sehingga tujuan Tata Kelola serta manajemen dalam area tersebut belum tercapai.
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Automatically open system print dialog on page load -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>

</body>
</html>
