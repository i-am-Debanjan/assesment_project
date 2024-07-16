document.addEventListener('DOMContentLoaded', function() {
    const alertMessage = document.getElementById('alert-message'); 
    if (alertMessage) {
        setTimeout(() => {
            alertMessage.remove();
        }, 4000); // show for 4 seconds
    }
});