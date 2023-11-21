// code prettify enable
import 'code-prettify';
window.addEventListener('load' , PR.prettyPrint , false)

// enable bootstrap tooltips
document.addEventListener("DOMContentLoaded", function () {
    let tooltipTriggerList = [].slice.call(document.querySelectorAll("[data-bs-toggle=\'tooltip\']"));
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


// copy to clipboard button
let copyButton = document.getElementById("copyButton");
let originalTitle = copyButton.getAttribute('title');
let isNewTitle = false;
copyButton.addEventListener('click', () => {
    try {
        const element = document.getElementById("copyText");
        navigator.clipboard.writeText(element.textContent);
        console.log("Text copied to clipboard!");
        // Optional: Display a success message to the user


        // change tooltip title
        if (isNewTitle) {
            copyButton.setAttribute('data-bs-original-title', originalTitle);
        } else {
            copyButton.setAttribute('data-bs-original-title', 'Successfully Copied to Clipboard');
        }

        let bsTooltip = bootstrap.Tooltip.getInstance(copyButton);
        bsTooltip._fixTitle();
        bsTooltip.show(); // Show the updated tooltip

        isNewTitle = !isNewTitle; // Toggle the state


    } catch (error) {
        console.error("Failed to copy to clipboard:", error);
        // Optional: Display an error message to the user
    }
})

