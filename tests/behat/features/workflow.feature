Feature: Basic workflow
  Basic scenarios

  Scenario: Multiple MEP
    Given nobody is deploying
    When user USER1 requires to MEP project PROJECT1
    And user USER1 requires to MEP project PROJECT2
    And user USER2 requires to MEP project PROJECT1
    And user USER2 requires to MEP project PROJECT3
    Then the global status should be:
      | project  | users |
      | PROJECT1 | USER1,USER2 |
      | PROJECT2 | USER1 |
      | PROJECT3 | USER2 |