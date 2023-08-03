// When the Change button is clicked on the Edit site page
function onChangeButtonClick() {
    // Show the message to confirm change
    var answer = confirm('Do you want to change this site?');
    return answer;
}

// When the Delete button is clicked on the Edit site page
function onDeleteButtonClick() {
    // Get site ID from HTML using hidden type
    var siteId = document.getElementById("siteId").value;
    //alert(siteId);

    // Show the message to confirm deletion
    var answer = confirm('Do you want to delete this site?');

    // If the user clicks "OK"
    if(answer === true){
        // Call deleteSite.php with the site ID
        fetch('../php/deleteSite.php', { // Destination
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(siteId.toString()) // Convert to json format and attach
        });
        //.then(response => response.json()) // Receive the returned response by json and pass it to the next then
        //.then(res => {
        //    console.log(res); // Returned data
        //})

        // Show the message and transition to mysites page
        if(!alert('Deleted!')){
            location.href = "../pages/mysites.php";
        }   
    }
}

// When the Change validity button is clicked on the Manage site page
function onValidityButtonClick() {
    var answer = confirm('Do you want to change the validity?');
    return answer;
}