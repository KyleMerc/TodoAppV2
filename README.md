# TODO App
<img src="SQL_Backup/TODO_ERD.png" width="600" height="600" style="float: right;">



### Notes
- Admin is already created.
- Admin can't update it's own password.
- User need to register.
- User can't update password only the Admin can.


## C.R.U.D
### User
1. Create Todo
	- Title
	- Content
2. Read Todo
	- Date created and updated
	- Title
	- Status
	- Content
3. Update Todo
	- Display date created and updated
	- Title
	- Status
	- Content
	- Automatic datetime updated
4. Delete Todo

### Admin
* **For User Account**
	1. Read User
		- Date created and updated
		- Username
	2. Update User
		- Display date created and updated
		- Username
		- Password
		- Automatic datetime updated
	3. Delete User
* **For User Todo**
	1. Create User Todo
		- Title
		- Content
	2. Read User Todo
		- Display date created and updated
		- Title
		- Status
		- Content
	3. Update User Todo
		- Display date created and updated
		- Title
		- Status
		- Content
		- Automatic datetime updated
	4. Delete User Todo

**It seems that I can restrict the access of User to the other Todos of another User
but in Admin I just want to do it the same but I can't for now.**