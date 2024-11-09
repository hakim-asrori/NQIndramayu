<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CrawlQuran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl-quran';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $response = Http::withOptions(["verify" => false])->get("https://web-api.qurankemenag.net/quran-ayah?surah=1");
        // dd($response->json()["data"]);

        // for ($i = 1; $i < 115; $i++) {
        //     $response = Http::withOptions(["verify" => false])->get("https://web-api.qurankemenag.net/quran-ayah?surah=$i");
        //     if ($response->successful()) {
        //         $ayah = $response->json()["data"];

        //         foreach ($ayah as $value) {
        //             DB::table("ayah")->insert([
        //                 "surah_id" => $i,
        //                 "ayah" => $value["ayah"],
        //                 "page" => $value["page"],
        //                 "juz" => $value["juz"],
        //                 "manzil" => $value["manzil"],
        //                 "arabic" => $value["arabic"],
        //                 "kitabah" => $value["kitabah"],
        //                 "latin" => $value["latin"],
        //                 "translation" => $value["translation"],
        //                 "footnotes" => $value["footnotes"] ? $value["footnotes"] : "-",
        //             ]);
        //             $this->info("Surah $i and ayah " . $value["id"] . " Success");
        //         }
        //     } else {
        //         $this->error("Gagal");
        //     }
        // }
    }
}
