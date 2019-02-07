# create the store database
create database store;
# acess the new database
use store;
# create the store admin user with the password
# @see store/.env/DB_USERNAME
# @see store/.env/DB_SECRET
create user 'store_admin'@'localhost' IDENTIFIED WITH mysql_native_password BY '123456';
# grant acess to that user to the store database
grant all privileges on store  to 'store_admin'@'localhost';
# apply change of privileges
flush privileges;
