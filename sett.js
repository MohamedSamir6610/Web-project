// customer-settings.js
$(document).ready(function() {
    // Load saved customer settings from localStorage
    loadCustomerSettings();
    
    // Save profile settings
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
    
    // Save preferences
    $('#preferences-form').submit(function(e) {
        e.preventDefault();
        const preferences = {
            emailNotifications: $('#notifications').is(':checked'),
            smsNotifications: $('#sms-notifications').is(':checked'),
            favoriteDrink: $('#favorite-drink').val()
        };
        localStorage.setItem('customerPreferences', JSON.stringify(preferences));
        alert('Preferences saved successfully!');
    });
    
    // Change password (placeholder - in real app, handle securely)
    $('#change-password').click(function() {
        const newPassword = prompt('Enter new password:');
        if (newPassword) {
            // Simulate saving (in real app, send to server)
            alert('Password changed successfully!');
        }
    });
    
    // Delete account (placeholder)
    $('#delete-account').click(function() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            // Simulate deletion (in real app, send to server)
            localStorage.clear();
            alert('Account deleted.');
            window.location.href = 'index.html'; // Redirect to home
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
            $('#favorite-drink').val(preferences.favoriteDrink);
        }
    }
});