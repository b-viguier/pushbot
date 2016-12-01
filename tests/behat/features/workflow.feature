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