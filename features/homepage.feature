Feature: homepage
  In order to use homepage
  As any website user
  I need to see certain elements

Scenario: copyright notice
  Given I am on the homepage
  Then I should see "Designed and crafted from scratch by Laurynas Veržukauskas"

Scenario: home link
  Given I am on the homepage
  When I follow "Home"
  Then I should be on "/"

Scenario: login link
  Given I am on the homepage
  When I follow "Login"
  Then I should be on "/login/"

Scenario: author link
  Given I am on the homepage
  When I follow "Laurynas Veržukauskas"
  Then I should be on "http://im0rtality.com"

