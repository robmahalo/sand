from selenium import webdriver
from selenium.webdriver.common.keys import Keys

driver = webdriver.get("/Users/benjaminjensen/sandProject/sand/web/Firebase_app-master/FirebaseApp/resources/views/wel.blade.php");

username = browser.find_element_by_id("userName")
firstname = browser.find_element_by_id("firstName")
lastname = browser.find_element_by_id("lastName")
pwd = browser.find_element_by_id("pwd")
email = browser.find_element_by_id("email")
submit = browser.find_element_by_id("submit")
username.send_keys("ben")
firstname.send_keys("ben")
lastname.send_keys("jensen")
pwd.send_keys("test")
email.send_keys("bjensen@stetson.edu")
submit.click()

