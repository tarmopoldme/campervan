<?php
namespace App\Command;

use App\Classes\Order\Generator;
use App\Entity\Campervan;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command generates per campervan a random order
 * Before each run truncates order related and "station equipment demand" db tables
 */
class OrdersGenerateCommand extends Command
{
    private EntityManagerInterface $em;
    private Connection $con;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
        $this->con = $em->getConnection();
    }

    protected function configure(): void
    {
        $this
            ->setName('campervan:orders-generate')
            ->setDescription('Generates random orders for all campervans for testing purposes')
            ->addUsage('-vvv (for full exception stacks)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting orders generating...');

        $this->truncateTables();

        $campervans = $this->em->getRepository(Campervan::class)
            ->findAll()
        ;

        /** @var Campervan $campervan */
        foreach ($campervans as $campervan) {
            $output->writeln(sprintf('Generating order for campervan %d', $campervan->getId()));
            (new Generator($campervan, $this->em))->generate();
        }

        $output->writeln('Finished orders generating');

        return Command::SUCCESS;
    }

    private function truncateTables(): void
    {
        $platform = $this->con->getDatabasePlatform();
        if (!$platform) {
            throw new RuntimeException('No platform detected for db connection');
        }
        $this->con->executeStatement('SET foreign_key_checks = 0;');
        $this->con->executeStatement($platform->getTruncateTableSQL('cv_order_equipment', true));
        $this->con->executeStatement($platform->getTruncateTableSQL('cv_order', true));
        $this->con->executeStatement($platform->getTruncateTableSQL('cv_station_equipment_demand', true));
        $this->con->executeStatement('SET foreign_key_checks = 1;');
    }
}
