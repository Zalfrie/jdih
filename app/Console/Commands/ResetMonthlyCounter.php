<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Peraturan;
use App\Model\PerPopulerCounter;

class ResetMonthlyCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resetcounter:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Peraturan Populer Bulanan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(\Carbon\Carbon::now()->formatLocalized('%d %B %Y'));
        $peraturans = Peraturan::all();
        foreach($peraturans as $peraturan){
            \DB::beginTransaction();
            try {
                $populerCounter = new PerPopulerCounter;
                $populerCounter->per_no = $peraturan->per_no;
                $populerCounter->start_date = \Carbon\Carbon::now()->firstOfMonth()->yesterday()->firstOfMonth()->format('Y-m-d');
                $populerCounter->end_date = \Carbon\Carbon::now()->firstOfMonth()->yesterday()->lastOfMonth()->format('Y-m-d');
                $populerCounter->type = 1;
                $populerCounter->hit_counter = $peraturan->monthly_counter;
                $populerCounter->save();
                $peraturan->monthly_counter = 0;
                $peraturan->save();
            } catch(\Exception $e){
                $this->info(($peraturan->per_no.' gagal'));
                \DB::rollback();
                continue;
            }
            $this->info(($peraturan->per_no.' berhasil'));
            \DB::commit();
        }
    }
}
