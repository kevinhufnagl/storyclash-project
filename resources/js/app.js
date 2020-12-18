//const { update } = require('lodash');

import  './bootstrap';
import {getAllReports, uploadReport,updateReport,deleteReport} from './report';


const reportList = document.querySelector('.js-report-list');

//Report form DOM elements
const addReportForm = document.getElementById('addReportForm');
const addReportFormTitle = document.getElementById('title');
const formIconPreview = document.getElementById('icon-preview');
const formMessage = document.querySelector('.form-message');

//Loads all reports on page load once and calls function to add event listeners for the context menu of each item
getAllReports(data => {
    reportList.innerHTML = (data.html);
    updateContextMenuListeners();
})

//Used to preview the selected report icon, not necessary but better UX
const loadIcon = input => {
    if (input.files && input.files[0]) {
        var  reader = new FileReader();
        
        reader.onload = function (e) {
            //Removing background placeholder once the preview icon is loaded and setting background-image to the preview image
            formIconPreview.setAttribute('style', 'background-size:cover;background-color:transparent;background-image:url('+e.target.result+');');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}


const hideReportForm = () => {
    addReportForm.classList.remove('active');
}

/**
 * Clearing the content of the add report form
 */
const resetReportForm = () => {
    //Emptying form
    addReportForm.reset();
    //Removing preview icon
    document.getElementById('icon-preview').setAttribute('style', '');
}

/**
 * Hides all open context menus for reports.
 * Called when clicking anywhere in the document except the context menu itself.
 */
const hideAllContextMenus = () => {
    document.querySelectorAll('.js-report-menu').forEach((element) => {
        element.classList.remove('active');
    });
}

/**
 * Hide context menus when clicking anywhere in the document
 */
document.addEventListener('click', () => {
    hideAllContextMenus();
})




/**
 * Bind click events of the newly added report items
 * Called everytime the report list changes.
 * On page load and on succesful report upload
 */
const updateContextMenuListeners = () => {

    //Show context menu for a single report item
    document.querySelectorAll('.js-report-options').forEach((element) => {
        element.addEventListener('click', (e) => {
            e.stopPropagation();
            const reportItem = e.currentTarget.parentNode;
            const contextMenu = reportItem.querySelector('.js-report-menu');
            hideAllContextMenus();
            contextMenu.classList.toggle('active');
        });
    })

    /**
     * Deleting a report
     * Handles the click on "Delete" in the context menu for a single report
     */
    document.querySelectorAll('.js-delete-report').forEach((element) => {
        element.addEventListener('click', (e) => {
            const reportId = e.currentTarget.getAttribute('data-id');
            deleteReport(reportId);
        })
    });



    /**
     * Renaming a report
     * Handles the click on "Rename" in the context menu for a single report
     */
    document.querySelectorAll('.js-rename-report').forEach((element) => {
        element.addEventListener('click', (e) => {
            const report = e.currentTarget.parentNode.parentNode;

            //Adding a class to target a specific style for the report item used while renaming.
            report.classList.add('is-renaming');
            const reportId = e.currentTarget.getAttribute('data-id');
            const reportTitleElem = report.querySelector('.js-report-title');

            /**
             * Check if rename input is already inside, otherwise add it
             * This prevents adding infinite amount of inputs when repeatedly clicking on rename
             */
            if(!report.querySelector('.js-rename-input')) {


                //Create the input to rename the current report
                const renameInput = document.createElement('input');
                renameInput.setAttribute('type', 'text');
                renameInput.setAttribute('class', 'report__title--rename js-rename-input');
                renameInput.setAttribute('value', reportTitleElem.innerHTML);
                //Puts the cursor at the end when using focus()
                renameInput.setAttribute('onfocus', 'let value = this.value; this.value = null; this.value=value');


                //Helper function to hide rename input when finished or cancelled. Used in keydown event below.
                const hideRenameInput = () => {
                    renameInput.remove();
                    reportTitleElem.classList.remove('hidden');
                    report.classList.remove('is-renaming');
                }

                //Add listener for keys in rename input
                renameInput.addEventListener('keydown', (e) => {

                    //Cancel renaming
                    if(e.key === "Escape") {
                        hideRenameInput();
                    }
                    //Update the report via ajax
                    else if(e.key === "Enter") {
                        //Data used for ajax
                        const renameData = {
                            title: renameInput.value
                        };
                        updateReport(reportId, renameData);
                        hideRenameInput();
                    }
                })
    
                //Show input inside single report element
                report.appendChild(renameInput);
                renameInput.focus();
    
                //Hide the actual title div
                reportTitleElem.classList.add('hidden');
            }
        })
    });
}




//Toggle sidebar in and out when clicking on storyclash icon
document.querySelector('.js-toggle-sidebar').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('active');
})

//Hide sidebar with back button next to the bookmark icon
document.querySelector('.js-hide-sidebar').addEventListener('click', () => {
    document.getElementById('sidebar').classList.remove('active');
})

//Toggle reports visible / invisible
document.querySelector('.js-toggle-reports').addEventListener('click', () => {
    const makeActive = document.querySelectorAll('.js-toggle-reports-icon, .js-reports');
    makeActive.forEach(element => {
        element.classList.toggle('active');
    });
})


//Load preview icon for report after selection of image in file browser
document.getElementById('icon').addEventListener('change', (e) => {
    loadIcon(e.currentTarget);
})

//Shows the form to add a report on click of Save Report button
document.querySelector('.js-add-report').addEventListener('click', () => {
    addReportForm.classList.add('active');
    addReportFormTitle.focus();
})


//Handle form input for adding new report
document.getElementById('title').addEventListener('keydown', function(e){

    //Cancel form
	if(e.key === "Escape"){
        hideReportForm();
        resetReportForm();
        formMessage.innerHTML = "";
    }
    //Submit form data via ajax
    else if(e.key === "Enter") {
        let data = new FormData(addReportForm);
        uploadReport(data);
        addReportForm.classList.add('processing');
    }
});


/**
 * Event Listeners for the ajax results in report.js
 */

//Append uploaded report to DOM
document.addEventListener('reportUploadSuccess', (e) => {
    hideReportForm();
    resetReportForm();
    //Converting the returned html string into html code and appending it to the report list
    reportList.append(document.createRange().createContextualFragment(e.detail.html));
    formMessage.innerHTML = "";
    addReportForm.classList.remove('processing');
    updateContextMenuListeners();
})

document.addEventListener('reportUploadFail', (e) => {
    formMessage.innerHTML = e.detail.message;
    addReportForm.classList.remove('processing');
} )

//Remove deleted report from DOM
document.addEventListener('reportDeleteSuccess', (e) => {
    const deletedId = e.detail.data.id;
    document.querySelector(`.js-report-list li[data-id="${deletedId}"]`).remove();
})

document.addEventListener('reportDeleteFail', (e) => {
    console.log(e.detail);
})

//Change title to updated title of report in DOM
document.addEventListener('reportUpdateSuccess', (e) => {
    const updatedId = e.detail.data.id;
    //Setting the new title we retrieved from the response
    document.querySelector(`.js-report-list li[data-id="${updatedId}"] .js-report-title`).innerHTML = e.detail.data.title;
})

document.addEventListener('reportUpdateFail', (e) => {
    console.log(e.detail);
    
})