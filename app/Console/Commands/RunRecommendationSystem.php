<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RunRecommendationSystem extends Command
{
    protected $signature = 'recommendation:run';
    protected $description = 'Chạy hệ thống gợi ý sách';

    public function handle()
    {
        $pythonScript = base_path('python_scripts/recomandation_system.py');
        
        try {
            $process = new Process(['python3', $pythonScript]);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $this->info('Hệ thống gợi ý đã chạy thành công!');
            $this->info($process->getOutput());
            
        } catch (\Exception $e) {
            $this->error('Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}