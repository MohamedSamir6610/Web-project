function saveSettings() {
    alert("Your settings have been saved successfully ☕");
}

function deleteAccount() {
    var result = confirm("Are you sure you want to delete your account?");
    if (result) {
        alert("Account deleted");
    }
}
