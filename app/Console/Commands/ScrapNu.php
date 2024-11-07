<?php

namespace App\Console\Commands;

use App\Models\Maulid;
use App\Models\MaulidContent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapNu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrap-nu';

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
        $response = Http::withOptions(["verify" => false])->get("https://quran.nu.or.id/doa/maulid-al-azab");

        if ($response->successful()) {
            $html = $response->body();

            $crawler = new Crawler($html);

            $arabic = $crawler->filter(".nui-PageDoaDetail .max-w-screen-lg.mx-auto.mt-5 .border-b.border-neutral-100.py-5.px-3 .text-4xl.leading-relaxed")->each(function (Crawler $node) {
                return $node->text();
            });

            $latin = $crawler->filter(".nui-PageDoaDetail .max-w-screen-lg.mx-auto.mt-5 .border-b.border-neutral-100.py-5.px-3 .block.text-md.text-primary-500")->each(function (Crawler $node) {
                return $node->text();
            });

            $translation = $crawler->filter(".nui-PageDoaDetail .max-w-screen-lg.mx-auto.mt-5 .border-b.border-neutral-100.py-5.px-3 .block.text-md.text-neutral-700")->each(function (Crawler $node) {
                return $node->text();
            });

            // foreach ($arabic as $key => $value) {
            //     MaulidContent::create([
            //         "maulid_id" => 7,
            //         "latin" => $value,
            //         "arabic" => $latin[$key],
            //         "translation" => $translation[$key]
            //     ]);

            //     $this->info("iterasi ke-$key berhasil masuk database");
            // }
        } else {
            $this->error("Scraping Gagal");
        }
    }
}
