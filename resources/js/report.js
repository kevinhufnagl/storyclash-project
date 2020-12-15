/*
    CSRF protection for ajax requests
*/
const token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;


//Retrieves all reports and hands it to the callback function for use in app.js
export const getAllReports = (callback) => {
    window.axios.get('/reports')
    .then(res => {
        callback(res.data);
    })
    .catch(error => {
        console.log(error.response);
    });
}



//Uploads a report using axios and triggers appropriate events for use in app.js
let isUploading = false;
export const uploadReport = (data) => {
    if(!isUploading) {
        isUploading = true;

        window.axios({ 
            method  : 'post', 
            url : '/reports', 
            data : data, 
        }) 
        .then((res)=>{ 
            //Sending the uploaded report through the event so we can append it to the DOM in app.js
            document.dispatchEvent(new CustomEvent('reportUploadSuccess', {detail: res.data}));
            isUploading = false;
        }) 
        .catch((error) => {
            let response = {
                status: error.response.data.status,
                message: error.response.data.message
            }
            //Seperately handling the php upload limit
            console.log(error.response);
            if(error.response.status === 413) {
                response.message = "Exceeded upload size limit";
            }
            document.dispatchEvent(new CustomEvent('reportUploadFail', {detail: response}));
            isUploading = false;
        }); 
    }
}

//Deletes a report using axios and triggers appropriate events for use in app.js
export const deleteReport = (reportId) => {
    window.axios.post(`/reports/${reportId}`, {
        _method:'delete'
    }).then(res => {
        //Sending the deleted report through the event so we can delete it from the DOM in app.js
        document.dispatchEvent(new CustomEvent('reportDeleteSuccess', {detail: res.data}));
    }).catch(error => {
        document.dispatchEvent(new CustomEvent('reportDeleteFail', {detail: error.response}));
    })
}

//Updates a report using axios and triggers appropriate events for use in app.js
export const updateReport = (reportId, data) => {
    //Adding the method to the data being sent so we target the update function in the backend.
    data = {
        _method: 'put',
        ...data
    };
    window.axios.post(`/reports/${reportId}`, data).then(res => {
        //Sending the updated data through the event caught in app.js
        document.dispatchEvent(new CustomEvent('reportUpdateSuccess', {detail: res.data}));
    }).catch(error => {
        document.dispatchEvent(new CustomEvent('reportUpdateFail', {detail: error.response}));
    })
}

//export {getAllReports, uploadReport, updateReport, deleteReport};