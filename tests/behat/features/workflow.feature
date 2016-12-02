Feature: Basic workflow
  Basic scenarios

  Scenario: Multiple MEP
    Given nobody is deploying
    When user A succeeds to MEP project 1
    And user A succeeds to MEP project 2
    And user A fails to MEP project 2
    And user B fails to MEP project 1
    And user B succeeds to MEP project 3
    Then the global status should be:
      | project  | users |
      | 1 | A,B |
      | 2 | A |
      | 3 | B |
    
  Scenario: MEP is DONE
    Given user A is deploying project 1
    And user B is deploying project 1
    When user B fails to DONE project 1
    And user A succeeds to DONE project 1
    And user A fails to DONE project 1
    Then the global status should be:
      | project  | users |

  Scenario: pushbot tells users that they can MEP
    Given user Alice is deploying project 1
    When user Bob fails to MEP project 1
    And user Alice succeeds to DONE project 1
    Then last output must contains Bob

  Scenario: user can CANCEL a MEP
    Given user Alice is deploying project 1
    When user Bob fails to CANCEL project 1
    And user Bob fails to MEP project 1
    And user Charly fails to MEP project 1
    When user Bob succeeds to CANCEL project 1
    When user Alice succeeds to CANCEL project 1
    Then last output must contains Charly
    And the global status should be:
      | project  | users |
      | 1 | Charly |

  Scenario: global empty status
    Given nobody is deploying
    When user A succeeds to STATUS
    Then last output must contains Nothing

  Scenario: local empty status
    Given nobody is deploying
    When user A succeeds to STATUS project 1
    Then last output must contains Nothing

  Scenario: global status with 1 project
    Given user Alice is deploying project P1
    And user Bob is deploying project P1
    When user A succeeds to STATUS
    Then last output must contains P1
    And last output must contains Alice
    And last output must contains Bob

  Scenario: local status with 1 project
    Given user Alice is deploying project P1
    And user Bob is deploying project P1
    When user A succeeds to STATUS project P1
    Then last output must contains P1
    And last output must contains Alice
    And last output must contains Bob

  Scenario: global status with several projects
    Given user Alice is deploying project P1
    And user Bob is deploying project P2
    When user A succeeds to STATUS
    Then last output must contains P1
    And last output must contains Alice
    And last output must contains P2
    And last output must contains Bob

  Scenario: local status with several projects
    Given user Alice is deploying project P1
    And user Bob is deploying project P2
    When user A succeeds to STATUS project P1
    Then last output must contains P1
    And last output must contains Alice
    And last output "must not" contains P2
    And last output "must not" contains Bob