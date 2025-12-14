
$(document).ready(function() {
    
    loadCustomerSettings();
    
    
    $('#profile-form').submit(function(e) {
        e.preventDefault();
        const profile = {
            fullName: $('#full-name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            address: $('#address').val()
        };
        localStorage.setItem('customerProfile', JSON.stringify(profile));
        alert('Profile saved successfully!');
    });
    
   
    $('#preferences-form').submit(function(e) {
        e.preventDefault();
        const preferences = {
            emailNotifications: $('#notifications').is(':checked'),
            smsNotifications: $('#sms-notifications').is(':checked'),
            
        };
        localStorage.setItem('customerPreferences', JSON.stringify(preferences));
        alert('Preferences saved successfully!');
    });
    
    
    $('#change-password').click(function() {
        const newPassword = prompt('Enter new password:');
        if (newPassword) {
            
            alert('Password changed successfully!');
        }
    });
    
    
    $('#delete-account').click(function() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            
            localStorage.clear();
            alert('Account deleted.');
            window.location.href = 'home.html'; 
        }
    });
    
    
    $('#logout-btn').click(function() {
        if (confirm('Are you sure you want to log out?')) {
            
            localStorage.removeItem('customerProfile');
            localStorage.removeItem('customerPreferences');
            alert('You have been logged out.');
            window.location.href = 'login.html'; 
        }
    });
    
    function loadCustomerSettings() {
        const profile = JSON.parse(localStorage.getItem('customerProfile'));
        if (profile) {
            $('#full-name').val(profile.fullName);
            $('#email').val(profile.email);
            $('#phone').val(profile.phone);
            $('#address').val(profile.address);
        }
        
        const preferences = JSON.parse(localStorage.getItem('customerPreferences'));
        if (preferences) {
            $('#notifications').prop('checked', preferences.emailNotifications);
            $('#sms-notifications').prop('checked', preferences.smsNotifications);
            
        }
    }
});