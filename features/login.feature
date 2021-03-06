Feature: login
  In order to use advanced features of system
  As a registered user
  I need to log in

Scenario: login user
  Given I am on the homepage
  When I follow "Login"
  And I should see "Prisijungimas"
  When I fill in "name" with "test"
  And I fill in "pass" with "test"
  And I press "Prisijungti"
  Then I should see "Logout (test)"

Scenario: login admin
  Given I am on the homepage
  When I follow "Login"
  And should see "Prisijungimas"
  When I fill in "name" with "admin"
  And fill in "pass" with "admin"
  And press "Prisijungti"
  And should see "Logout (admin)"
  When I follow "Admin"
  Then I should be on "/admin/"

Scenario: fill in comment
  Given I am on the homepage
  When I follow "Login"
  And I should see "Prisijungimas"
  When I fill in "name" with "test"
  And I fill in "pass" with "test"
  And I press "Prisijungti"
  When I follow "algoritmas"
  And should see "Baigtinė seka aiškiai suformuluotų nurodymų"
  When I fill in "comment" with "Testing comment system"
  And press "Siųsti"
  And I go to the homepage
  And I follow "algoritmas"
  Then I should see "Testing comment system"
