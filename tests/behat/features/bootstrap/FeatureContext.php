<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use M6\Pushbot;
use M6\Pushbot\Command;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    const ROOT_DIR = __DIR__ . '/../../../..';

    private $pushbot;

    private $persister;

    private $last_response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->pushbot = new Pushbot\Pushbot(
            new Pushbot\Deployment\Pool(),
            $this->persister = new Pushbot\Deployment\Pool\Persister\PhpArray()
        );

        $this->pushbot
            ->registerCommand(Command\Status::class)
            ->registerCommand(Command\Mep::class)
            ->registerCommand(Command\Done::class)
            ->registerCommand(Command\Cancel::class)
        ;
    }

    /**
     * @Given nobody is deploying
     */
    public function nobodyIsDeploying()
    {
        $this->persister->data = [];
    }

    /**
     * @Given user :user is deploying project :project
     */
    public function userIsDeployingProject($user, $project)
    {
        $this->persister->data[$project] = $this->persister->data[$project] ?? [];
        $this->persister->data[$project][] = [
            'user' => $user,
        ];
    }

    /**
     * @When user :user :state to :action project :project
     */
    public function userRequiresToDoSomethingOnProject(string $user, string $state, string $action, string $project)
    {
        $this->last_response = $this->pushbot->execute(
            $user,
            $action,
            [$project]
        );

        switch($state) {
            case 'succeeds' :
                if( $this->last_response->status != Pushbot\Response::SUCCESS) {
                    throw new \ErrorException(
                        sprintf('Command failed [%s]', $this->last_response->body)
                    );
                }
                break;
            case 'fails':
                if( $this->last_response->status != Pushbot\Response::FAILURE) {
                    throw new \ErrorException(
                        sprintf('Command succeeded [%s]', $this->last_response->body)
                    );
                }
                break;
            default:
                throw new \ErrorException(
                    sprintf('Unexpected state [%s] (expecting "fails" or "succeds")', $state)
                );
        }
    }

    /**
     * @Then the global status should be:
     */
    public function theGlobalStatusShouldBe(TableNode $table)
    {
        foreach ($table as $row) {
            $project_deployments = $this->persister->data[$row['project']] ?? null;
            if ($project_deployments === null) {
                throw new ErrorException(sprintf('No data for project [%s]', $row['project']));
            }

            $users = explode(',', $row['users']);
            if ($users !== array_column($project_deployments, 'user')) {
                throw new ErrorException(sprintf('Unexpected users [%s] for project [%s]', implode(',', $project_deployments), $row['project']));
            }
        }
    }

    /**
     * @Then last output must contains :word
     */
    public function lastOutputMustContainsAlice($word)
    {
        if (false === strpos($this->last_response->body, $word)) {
            throw new ErrorException(
                sprintf('Output [%s] does not contains [%s]', $this->last_response->body, $word)
            );
        }
    }
}
