Feature: login
  In order to use advanced features of system
  As a registered user
  I need to log in

Scenario: login
  Given I am on the homepage
  When I follow "Login"
  Then I should be on "/login/"
  When I fill in "name" with "test"
  And I fill in "pass" with "test"
  And I press "Prisijungti"
  Then I should be on "/"
  And I should see "Logout (test)"

