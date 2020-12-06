<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UpdateServerSSHKeyService;

class UpdateServerSSHKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_server_ssh_key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update multiple server SSH keys';

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
        $range = $this->choice('Which servers would you like to update SSH Keys for?', [
            'all' => 'All Server',
            'select' => 'Selected Server',
        ]);

        if ($range === 'select') {
            $serviceNames = $this->choice(
                'Which servers would you like to update SSH Keys for? ( Select the appropriate numbers separated by commas. )',
                $this->getServiceNames(),
                null,
                null,
                true
            );
        } else {
            $serviceNames = $this->getServiceNames();
        }

        /** @var UpdateServerSSHKeyService $updateServerSSHKeyService */
        $updateServerSSHKeyService = resolve(UpdateServerSSHKeyService::class);

        $this->output->progressStart(count($serviceNames));
        foreach ($serviceNames as $serviceName) {
            $this->output->write("<info>   ( {$serviceName} Updating... )</info>");
            $updateServerSSHKeyService->update($serviceName);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        $this->output->success('Succeed.');
    }

    private function getServiceNames(): array
    {
        return collect(config('remote.connections'))->keys()->toArray();
    }
}
