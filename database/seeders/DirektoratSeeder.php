<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Direktorat;
use App\Models\SubDirektorat;
use App\Models\Divisi;

class DirektoratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Direksi Jasa Keuangan
        $direksiJasaKeuangan = Direktorat::create(['name' => 'Direktorat Jasa Keuangan']);

        // A. Sub Direktorat Government and Corporate Business
        $subGovCorp = SubDirektorat::create([
            'name' => 'Sub Direktorat Government and Corporate Business',
            'direktorat_id' => $direksiJasaKeuangan->id
        ]);

        Divisi::create(['name' => 'Divisi Penyaluran Dana', 'sub_direktorat_id' => $subGovCorp->id, 'pic_name' => 'Ahmad Rizki', 'nippos' => '123456789']);
        Divisi::create(['name' => 'Divisi Fronting Business', 'sub_direktorat_id' => $subGovCorp->id, 'pic_name' => 'Siti Nurhaliza', 'nippos' => '234567890']);
        Divisi::create(['name' => 'Divisi Financial Services Marketing', 'sub_direktorat_id' => $subGovCorp->id, 'pic_name' => 'Budi Santoso', 'nippos' => '345678901']);
        Divisi::create(['name' => 'Divisi Payment', 'sub_direktorat_id' => $subGovCorp->id, 'pic_name' => 'Dewi Sartika', 'nippos' => '456789012']);

        // B. Sub Direktorat Costumer Business
        $subCustomer = SubDirektorat::create([
            'name' => 'Sub Direktorat Costumer Business',
            'direktorat_id' => $direksiJasaKeuangan->id
        ]);

        Divisi::create(['name' => 'Divisi Digital Giro and Payment Solution', 'sub_direktorat_id' => $subCustomer->id, 'pic_name' => 'Rina Marlina', 'nippos' => '567890123']);
        Divisi::create(['name' => 'Divisi Remittance and Syariah Business', 'sub_direktorat_id' => $subCustomer->id, 'pic_name' => 'Hendra Gunawan', 'nippos' => '678901234']);
        Divisi::create(['name' => 'Divisi Modern Channel Financial Services', 'sub_direktorat_id' => $subCustomer->id, 'pic_name' => 'Maya Indah', 'nippos' => '789012345']);
        Divisi::create(['name' => 'Divisi Product Management', 'sub_direktorat_id' => $subCustomer->id, 'pic_name' => 'Agus Setiawan', 'nippos' => '890123456']);

        // 2. Direksi Bisnis Kurir & Logistik
        $direksiKurirLogistik = Direktorat::create(['name' => 'Direktorat Bisnis Kurir & Logistik']);

        // A. Sub Direktorat Enterprise Business
        $subEnterprise = SubDirektorat::create([
            'name' => 'Sub Direktorat Enterprise Business',
            'direktorat_id' => $direksiKurirLogistik->id
        ]);

        Divisi::create(['name' => 'Divisi Account Management and Corporate Marketing', 'sub_direktorat_id' => $subEnterprise->id, 'pic_name' => 'Eko Prasetyo', 'nippos' => '901234567']);
        Divisi::create(['name' => 'Divisi Project Management', 'sub_direktorat_id' => $subEnterprise->id, 'pic_name' => 'Nina Kartika', 'nippos' => '012345678']);
        Divisi::create(['name' => 'Divisi Bidding and Collection Management', 'sub_direktorat_id' => $subEnterprise->id, 'pic_name' => 'Rudi Hartono', 'nippos' => '111111111']);
        Divisi::create(['name' => 'Divisi Solution, Partnership, Business Planning and Performance', 'sub_direktorat_id' => $subEnterprise->id, 'pic_name' => 'Lina Marlina', 'nippos' => '222222222']);

        // B. Sub Direktorat Retail Business
        $subRetail = SubDirektorat::create([
            'name' => 'Sub Direktorat Retail Business',
            'direktorat_id' => $direksiKurirLogistik->id
        ]);

        Divisi::create(['name' => 'Divisi Digital Channel PosAja', 'sub_direktorat_id' => $subRetail->id, 'pic_name' => 'Doni Kusuma', 'nippos' => '333333333']);
        Divisi::create(['name' => 'Divisi Marketing Retail Business', 'sub_direktorat_id' => $subRetail->id, 'pic_name' => 'Sari Indah', 'nippos' => '444444444']);
        Divisi::create(['name' => 'Divisi Penjualan Agenpos', 'sub_direktorat_id' => $subRetail->id, 'pic_name' => 'Bambang Sutejo', 'nippos' => '555555555']);
        Divisi::create(['name' => 'Divisi O-Ranger', 'sub_direktorat_id' => $subRetail->id, 'pic_name' => 'Yuni Safitri', 'nippos' => '666666666']);
        Divisi::create(['name' => 'Divisi Kemitraan dan Solusi', 'sub_direktorat_id' => $subRetail->id, 'pic_name' => 'Ahmad Fauzi', 'nippos' => '777777777']);

        // C. Sub Direktorat Wholesale and International Business
        $subWholesale = SubDirektorat::create([
            'name' => 'Sub Direktorat Wholesale and International Business',
            'direktorat_id' => $direksiKurirLogistik->id
        ]);

        Divisi::create(['name' => 'Divisi Account International Business', 'sub_direktorat_id' => $subWholesale->id, 'pic_name' => 'Rina Safitri', 'nippos' => '888888888']);
        Divisi::create(['name' => 'Divisi Wholesale and International Freight', 'sub_direktorat_id' => $subWholesale->id, 'pic_name' => 'Dedi Kurniawan', 'nippos' => '999999999']);

        // 3. Direksi Operasi dan Digital Service
        $direksiOperasi = Direktorat::create(['name' => 'Direktorat Operasi dan Digital Service']);

        // A. Sub Direktorat Courier and Logistic Operation
        $subCourier = SubDirektorat::create([
            'name' => 'Sub Direktorat Courier and Logistic Operation',
            'direktorat_id' => $direksiOperasi->id
        ]);

        Divisi::create(['name' => 'Divisi Courier Operation', 'sub_direktorat_id' => $subCourier->id, 'pic_name' => 'Maya Sari', 'nippos' => '111111112']);
        Divisi::create(['name' => 'Divisi Digital Operation and Quality Assurance', 'sub_direktorat_id' => $subCourier->id, 'pic_name' => 'Budi Prasetyo', 'nippos' => '111111113']);
        Divisi::create(['name' => 'Divisi Operation Cost Management and Partnership', 'sub_direktorat_id' => $subCourier->id, 'pic_name' => 'Siti Aisyah', 'nippos' => '111111114']);
        Divisi::create(['name' => 'Divisi Logistic Operation', 'sub_direktorat_id' => $subCourier->id, 'pic_name' => 'Hendra Wijaya', 'nippos' => '111111115']);

        // B. Sub Direktorat International Post Services
        $subInternational = SubDirektorat::create([
            'name' => 'Sub Direktorat International Post Services',
            'direktorat_id' => $direksiOperasi->id
        ]);

        Divisi::create(['name' => 'Divisi Operation Control', 'sub_direktorat_id' => $subInternational->id, 'pic_name' => 'Rudi Santoso', 'nippos' => '111111116']);
        Divisi::create(['name' => 'Divisi Networking, Partnership and Process Operation Development', 'sub_direktorat_id' => $subInternational->id, 'pic_name' => 'Nina Safitri', 'nippos' => '111111117']);

        // C. Sub Direktorat Digital Services
        $subDigital = SubDirektorat::create([
            'name' => 'Sub Direktorat Digital Services',
            'direktorat_id' => $direksiOperasi->id
        ]);

        Divisi::create(['name' => 'Divisi Architecture and Governance', 'sub_direktorat_id' => $subDigital->id, 'pic_name' => 'Agus Setiawan', 'nippos' => '111111118']);
        Divisi::create(['name' => 'Divisi Digital Channel', 'sub_direktorat_id' => $subDigital->id, 'pic_name' => 'Dewi Sartika', 'nippos' => '111111119']);
        Divisi::create(['name' => 'Divisi Digital System Implementation', 'sub_direktorat_id' => $subDigital->id, 'pic_name' => 'Eko Prasetyo', 'nippos' => '111111120']);
        Divisi::create(['name' => 'Divisi Digital System Operation', 'sub_direktorat_id' => $subDigital->id, 'pic_name' => 'Lina Marlina', 'nippos' => '111111121']);
        Divisi::create(['name' => 'Divisi Network and Infrastructure', 'sub_direktorat_id' => $subDigital->id, 'pic_name' => 'Bambang Sutejo', 'nippos' => '111111122']);

        // D. Sub Direktorat Fronting Management and Financial Transaction Service
        $subFronting = SubDirektorat::create([
            'name' => 'Sub Direktorat Fronting Management and Financial Transaction Service',
            'direktorat_id' => $direksiOperasi->id
        ]);

        Divisi::create(['name' => 'Divisi Operasi Pelayanan', 'sub_direktorat_id' => $subFronting->id, 'pic_name' => 'Yuni Safitri', 'nippos' => '111111123']);
        Divisi::create(['name' => 'Divisi Operasi Jasa Keuangan', 'sub_direktorat_id' => $subFronting->id, 'pic_name' => 'Ahmad Fauzi', 'nippos' => '111111124']);

        // 4. Direktorat Keuangan dan Manajemen Resiko
        $direktoratKeuangan = Direktorat::create(['name' => 'Direktorat Keuangan dan Manajemen Resiko']);

        // A. Sub Direktorat Financial Operations and Business Partner
        $subFinancial = SubDirektorat::create([
            'name' => 'Sub Direktorat Financial Operations and Business Partner',
            'direktorat_id' => $direktoratKeuangan->id
        ]);

        Divisi::create(['name' => 'Divisi Manajemen Keuangan', 'sub_direktorat_id' => $subFinancial->id, 'pic_name' => 'Rina Marlina', 'nippos' => '111111125']);
        Divisi::create(['name' => 'Divisi Akuntansi', 'sub_direktorat_id' => $subFinancial->id, 'pic_name' => 'Doni Kusuma', 'nippos' => '111111126']);

        // B. Sub Direktorat Financial Policy and Asset Management
        $subPolicy = SubDirektorat::create([
            'name' => 'Sub Direktorat Financial Policy and Asset Management',
            'direktorat_id' => $direktoratKeuangan->id
        ]);

        Divisi::create(['name' => 'Divisi Financial Policy', 'sub_direktorat_id' => $subPolicy->id, 'pic_name' => 'Sari Indah', 'nippos' => '111111127']);
        Divisi::create(['name' => 'Divisi Asset Management', 'sub_direktorat_id' => $subPolicy->id, 'pic_name' => 'Bambang Sutejo', 'nippos' => '111111128']);
        Divisi::create(['name' => 'Divisi Investment Management', 'sub_direktorat_id' => $subPolicy->id, 'pic_name' => 'Yuni Safitri', 'nippos' => '111111129']);

        // C. Sub Direktorat Risk Management
        $subRisk = SubDirektorat::create([
            'name' => 'Sub Direktorat Risk Management',
            'direktorat_id' => $direktoratKeuangan->id
        ]);

        Divisi::create(['name' => 'Divisi Risk Management Policy and Strategy', 'sub_direktorat_id' => $subRisk->id, 'pic_name' => 'Ahmad Fauzi', 'nippos' => '111111130']);
        Divisi::create(['name' => 'Divisi Enterprise Risk Management', 'sub_direktorat_id' => $subRisk->id, 'pic_name' => 'Rina Safitri', 'nippos' => '111111131']);
        Divisi::create(['name' => 'Divisi Fraud Management', 'sub_direktorat_id' => $subRisk->id, 'pic_name' => 'Dedi Kurniawan', 'nippos' => '111111132']);

        // 5. Direktorat Human Capital Management
        $direktoratHC = Direktorat::create(['name' => 'Direktorat Human Capital Management']);

        // A. Sub Direktorat Human Capital Policy and Strategy
        $subHCPolicy = SubDirektorat::create([
            'name' => 'Sub Direktorat Human Capital Policy and Strategy',
            'direktorat_id' => $direktoratHC->id
        ]);

        Divisi::create(['name' => 'Divisi Human Capital Policy', 'sub_direktorat_id' => $subHCPolicy->id, 'pic_name' => 'Maya Sari', 'nippos' => '111111133']);
        Divisi::create(['name' => 'Divisi Human Capital Strategy', 'sub_direktorat_id' => $subHCPolicy->id, 'pic_name' => 'Budi Prasetyo', 'nippos' => '111111134']);
        Divisi::create(['name' => 'Divisi Culture Management', 'sub_direktorat_id' => $subHCPolicy->id, 'pic_name' => 'Siti Aisyah', 'nippos' => '111111135']);
        Divisi::create(['name' => 'Divisi General Support', 'sub_direktorat_id' => $subHCPolicy->id, 'pic_name' => 'Hendra Wijaya', 'nippos' => '111111136']);

        // B. Sub Direktorat Human Capital Services and Business Partner
        $subHCServices = SubDirektorat::create([
            'name' => 'Sub Direktorat Human Capital Services and Business Partner',
            'direktorat_id' => $direktoratHC->id
        ]);

        Divisi::create(['name' => 'Divisi Human Capital Service', 'sub_direktorat_id' => $subHCServices->id, 'pic_name' => 'Rudi Santoso', 'nippos' => '111111137']);
        Divisi::create(['name' => 'Divisi Human Capital Development', 'sub_direktorat_id' => $subHCServices->id, 'pic_name' => 'Nina Safitri', 'nippos' => '111111138']);
        Divisi::create(['name' => 'Divisi Digital Learning Center', 'sub_direktorat_id' => $subHCServices->id, 'pic_name' => 'Agus Setiawan', 'nippos' => '111111139']);
        Divisi::create(['name' => 'Divisi Human Capital Business Partner', 'sub_direktorat_id' => $subHCServices->id, 'pic_name' => 'Dewi Sartika', 'nippos' => '111111140']);

        // 6. Direksi Business Development dan Portfolio Management
        $direksiBD = Direktorat::create(['name' => 'Direktorat Business Development dan Portfolio Management']);

        // A. Sub Direktor Strategic Planning and Business Development
        $subStrategic = SubDirektorat::create([
            'name' => 'Sub Direktor Strategic Planning and Business Development',
            'direktorat_id' => $direksiBD->id
        ]);

        Divisi::create(['name' => 'Divisi Corporate Performance', 'sub_direktorat_id' => $subStrategic->id, 'pic_name' => 'Eko Prasetyo', 'nippos' => '111111141']);
        Divisi::create(['name' => 'Divisi Corporate Strategic Planning and Synergy Business', 'sub_direktorat_id' => $subStrategic->id, 'pic_name' => 'Lina Marlina', 'nippos' => '111111142']);
        Divisi::create(['name' => 'Divisi Business Development, Innovation and Incubation', 'sub_direktorat_id' => $subStrategic->id, 'pic_name' => 'Bambang Sutejo', 'nippos' => '111111143']);
        Divisi::create(['name' => 'Divisi Customer Experience', 'sub_direktorat_id' => $subStrategic->id, 'pic_name' => 'Yuni Safitri', 'nippos' => '111111144']);

        // B. Sub Direktor Portfolio Management
        $subPortfolio = SubDirektorat::create([
            'name' => 'Sub Direktor Portfolio Management',
            'direktorat_id' => $direksiBD->id
        ]);

        Divisi::create(['name' => 'Divisi Transformation Management Office', 'sub_direktorat_id' => $subPortfolio->id, 'pic_name' => 'Ahmad Fauzi', 'nippos' => '111111145']);
        Divisi::create(['name' => 'Divisi Public Service Obligation', 'sub_direktorat_id' => $subPortfolio->id, 'pic_name' => 'Rina Safitri', 'nippos' => '111111146']);

        // 7. Non-Direktorat
        $nonDirektorat = Direktorat::create(['name' => 'Non-Direktorat']);

        // A. Corsec and ESG
        $subCorsec = SubDirektorat::create([
            'name' => 'Corsec and ESG',
            'direktorat_id' => $nonDirektorat->id
        ]);

        Divisi::create(['name' => 'Divisi Corporate Communication', 'sub_direktorat_id' => $subCorsec->id, 'pic_name' => 'Dedi Kurniawan', 'nippos' => '111111147']);
        Divisi::create(['name' => 'Divisi Legal', 'sub_direktorat_id' => $subCorsec->id, 'pic_name' => 'Maya Sari', 'nippos' => '111111148']);
        Divisi::create(['name' => 'Divisi Regulation', 'sub_direktorat_id' => $subCorsec->id, 'pic_name' => 'Budi Prasetyo', 'nippos' => '111111149']);
        Divisi::create(['name' => 'Divisi Tanggung Jawab Sosial dan Lingkungan', 'sub_direktorat_id' => $subCorsec->id, 'pic_name' => 'Siti Aisyah', 'nippos' => '111111150']);

        // B. Internal Audit
        $subAudit = SubDirektorat::create([
            'name' => 'Internal Audit',
            'direktorat_id' => $nonDirektorat->id
        ]);

        Divisi::create(['name' => 'Divisi Deputi Bidang Enabler (Human Capital, Umum dan Keuangan)', 'sub_direktorat_id' => $subAudit->id, 'pic_name' => 'Hendra Wijaya', 'nippos' => '111111151']);
        Divisi::create(['name' => 'Divisi Deputi Bidang Bisnis Layanan Keuangan', 'sub_direktorat_id' => $subAudit->id, 'pic_name' => 'Rudi Santoso', 'nippos' => '111111152']);
        Divisi::create(['name' => 'Divisi Deputi Bidang Operasi, Teknologi Informasi, dan Digital Solution', 'sub_direktorat_id' => $subAudit->id, 'pic_name' => 'Nina Safitri', 'nippos' => '111111153']);
        Divisi::create(['name' => 'Divisi Deputi Bidang Bisnis Kurir, Logistik, Pos Internasional, dan Layanan Pos Universal', 'sub_direktorat_id' => $subAudit->id, 'pic_name' => 'Agus Setiawan', 'nippos' => '111111154']);
    }
}
