Feature: Who's who ?

  Scenario: Who's Who homepage ?
     When I visit the whoswho main page
     Then I should see "login"

 Scenario: Who's who homepage
    Given I am login as an user
    And Database is set
    When I visit the whoswho main page
    Then I should see "Liste des Fras"

 Scenario: Who's who homepage
    Given I am login as an user
    And Database is set
    And There is a fra "Malian" "De Ron" with slug "malianderon"
    When I visit the whoswho main page
    Then I should see "Liste des Fras (1)"
    Then I should see "Malian"

Scenario: Who's who user
    Given I am login as an user
    And Database is set
    And There is a fra "Malian" "De Ron" with slug "malianderon"
    When I visite the fra "malianderon"
    Then I should see "Fra: Malian De Ron"
