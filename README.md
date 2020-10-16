# STI-projet1

@Authors Laurent Scherer && Cassandre Wojciechowski
 

## Get started : 

* Add `127.0.0.1 sti` to : 
  * `%SystemRoot%\System32\drivers\etc\hosts` on Windows
  * `/etc/hosts` on Linux

```shell
$> git clone https://github.com/0x47726579/STI-projet1.git
$> cd STI-projet1
/STI-projet1 $> chmod +x script.sh
/STI-projet1 $> ./script.sh
```    

## Users

| username  | password  | role  | active  |
|---|---|---|---|
| user1  | asd  | Collaborator  | ✔
Administrator|IAmTheAlphaAndTheOmega|Administrator| ✔
Test|Test|Administrator| ❌
asd|asd|Collaborator| ❌
asdasd|asd|Collaborator| ✔
qwe|qwe|Collaborator| ✔
John|password|Collaborator| ✔
Cashew|salt|Administrator| ❌
Caroline|221205|Collaborator| ✔
Greg|TheGregginator|Collaborator| ✔
Bob|LeBricoleur|Collaborator| ✔
Jean-Henry|yxc|Collaborator| ✔

## Pages

### **login.php**

This page contains the code retrieving the information regarding the user trying to log in the website. This code will then verify the accuracy of the password used and if it is right, the session is set and the user is redirected to the page "index.php". If the username or the password is wrong, an error will appear on screen telling the user to check his credentials. If the account is disabled, the user will not be able to log in. 

### **index.php**

This page does not do anything special except welcoming the user and displaying the features he can use : the mailbox, the settings and the "logout" button.
Also Cat Facts.

### **mailbox.php**

When the user clicks on the "mailbox" button on the "index.php" page, it redirects him on this very page, where all the messages he received are displayed. He can then choose what to do with those messages : read them, reply to them or delete them. 
The code in this page interprets the user's inputs. If the user does not click any button, the display does not change.
When the user clicks on "Read", the code displays the message's informations (author, subject, date) and also displays two buttons to either reply or delete the message. When the user clicks on "Reply", the code displays an input box and below, the message being replied to. When the user clicks on "Delete", the code redirects him to the page "delete_msg.php". 
The user can also choose to write a new message by clicking on the "Write new" button. To write a new message, he has to enter a valid user existing in the database, a subject and the text for his message. Once he clicks the button "Send", the code inserts the message in the database. 

### **delete_msg.php**

This page contains the code that effectively deletes the message from the database and then redirects the user to the mailbox page.

### **settings.php**

This page allows the user to change his password. In order to do this, he must enter correctly his current password, which is verified in the database. He must then enter a new password and confirm it. The password must be new and the confirmation must be correct. When the user clicks the "Confirm" button, the code updates the database and changes the user's password effectively.

### **administration.php**

This page allows the website's administrator to manage the users. The users are displayed on the page but the administrator can choose to hide or reveal the list. He can choose to modify a user's password, role and enable/disable his account. He also can add a user to the database by providing a username and a password.
The code in this page performs all the SQLite requests induced by the administrator's choices. 

### **logout.php**

This page destroys the user's session and the session cookie. After logging out, the user must log in again and enter his credentials again. 

## **fragments**

### **header.php**

  This page connects to the database and establishes the user's role (collab / admin). If the user is an administrator, the "Administration" button will be displayed in the header and therefore, give this user access to the linked page.  It also checks if the user is marked as "active" ("inactive" users cannot log in). 

### **footer.php**

  This page contains the necessary code to display the template website page.

### **left_side_bar.php**

  This page retrieves the interesting "Cat Facts" that are included in this website's template.

## **functions**

### **connectDB.php**

  This function establishes a new connection to the database using PDO. 

### **message.php**

This helper gets informations about the messages displayed : the sender, the recipient, the date and time, the subject, the content and the various IDs (because of the database). It cleans the code because we can use the functions defined in this page instead of rewriting redundant code.
  Let's you send a message as well.

### **utils.php**

  This function facilitates the redirections. 
