Feature: Basic workflow
  Basic scenarios

  Scenario: Multiple MEP
    Given nobody is deploying
    When user A succeeds to MEP project 1
    And user A succeeds to MEP project 2
    And user A fails to MEP project 2
    And user B succeeds to MEP project 1
    And user B succeeds to MEP project 3
    Then the global status should be:
      | project  | users |
      | 1 | A,B |
      | 2 | A |
      | 3 | B |
    
  Scenario: MEP is DONE
    Given nobody is deploying
    When user A succeeds to MEP project 1
    And user A succeeds to DONE project 1
    And user A fails to DONE project 1
    And user B fails to DONE project 1
    Then the global status should be:
      | project  | users |