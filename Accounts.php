<!DOCTYPE html>
<html>

<head>

</head>

<body style="background-color: beige">

    <h1 style="text-align:center; border-bottom: 1px solid black;">Test Account Page</h1>

    <form action="server.php" method="POST" name='account_form' onsubmit='return validation()'>
        <div>
            <label for="#">First Name <span style="color: red">*</span>:</label>
            <input type="text" name='fname'>
        </div>
        <br>
        <div>
            <label for="#">Last Name <span style="color: red">*</span>:</label>
            <input type="text" name='lname'>
        </div>
        <br>
        <div>
            <label for="#">Email <span style="color: red">*</span>:</label>
            <input type="email" name='email_adr'>
        </div>
        <br>
        <div>
            <label for="#">Phone Number:</label>
            <input type="text" name='phone_num'>
        </div>
        <br>
        <div>
            <label for="#">Password <span style="color: red">*</span>:</label>
            <input type="password" name='passwrd' minlength="8" maxlength="20" required>
        </div>

        <input type="submit" id="submit_btn">
    </form>

    <script>
        /*SKELETON JAVASCRIPT VALIDATION CODE FOR INPUTS */

        //checks if the input is empty 
        function checkinput(DOM) {
            return DOM.value === "";
        }

        //valids the form and notifies the user about any problems
        function validation() {
            var list = document.querySelectorAll("input"); //list of all the inputs in the form
            var arr = []; //to contain any array messages
            for (i = 0; i < list.length - 1; i++) {
                if (checkinput(list[i])) { //user did not fill one of the fields
                    arr.push("Please fill the " + list[i].name + " correctly");
                    //Should make alert message more descritptive
                }
            }
            
            

            if (arr.length === 0) { // if form has been successfully field
                alert("Thank you for filling out this form");
                return true;

            } else {//form has not been filled successfully
                arr.forEach(element => {
                    alert(element);
                });
                return false;
            }
        
        }
    </script>

</body>

</html>
