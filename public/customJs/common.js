"use strict"
toastr.options = {
    "positionClass": "toast-bottom-right",
    "preventDuplicates" : true
}
const showloader = ()=>{
    $(".loading").removeClass('d-none')
}

const hideLoader = ()=>{
    $(".loading").addClass('d-none')
}

const makePostRequest = async (url, formData,formId)=>{
    try {
         showloader();
         const response  = await fetch(url,{
             method:'post',
             headers:{
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             body:new FormData(formData)
         })
         if(await checkStatus(response) !=200){
             await showErrorMessage (formId,response,formData)
         }
         else{
             const results = await response.json();
             if(results.type=="modal"){
                 toastr.success(results.message)
                 $("."+formId).find('form').trigger('reset');
                 $("."+formId).modal('hide');
                 table.draw();
                 hideLoader();
                 if(results.reload){
                     setTimeout(()=>{
                         hideLoader();
                         window.location.reload();
                     },2000)
                 }

             }if(results.redirect){
                hideLoader();
                toastr.success(results.message)
                return true;

            }else{

                 toastr.success(results.message)
                 setTimeout(()=>{
                     window.location.href = results.url;
                     hideLoader();
                 },2000)

             }
         }
    } catch (error) {
         hideLoader();
         toastr.error(error.message)
    }
 }

const showErrorMessage = async(form,res,formData) =>{
    hideLoader();
    $("#"+form).find('input').removeClass('is-invalid');
    $("#"+form).find('select').removeClass('is-invalid');
    $("#"+form).find('.text-danger').text('');
    const errors = await res.json();
    // console.log();
    if(await checkStatus(res) ==422){

        for(let index in errors.error){
            $("#"+form).find('input[name="' + index + '"]').addClass("is-invalid");
            if(index=='destination'){
                $("#"+form).find('select[name="' + index + '[]"]').addClass("is-invalid");
            }
            if(index=='images'){
                $("#"+form).find('input[name="' + index + '[]"]').addClass("is-invalid");
            }
            if(index=='multiple_images'){
                $("#"+form).find('input[name="' + index + '[]"]').addClass("is-invalid");

            }
            if(index=='permission'){
                $("."+index+"-error").css('display','block');
            }
            if (!errors.error?.permission || errors.error.permission.length === 0) {
                $(".permission-error").css('display','none');
            }
            if(index=='country_description'){
                $("."+index+"-error").css('display','block');
            }
            if(index=='destination_description'){
                $("."+index+"-error").css('display','block');
            }
            if(index=='package_description'){
                $("."+index+"-error").css('display','block');
            }
            if (!errors.error?.country_description || errors.error.country_description.length === 0) {
                $(".country_description-error").css('display','none');
            }
            if (!errors.error?.destination_description || errors.error.destination_description.length === 0) {
                $(".destination_description-error").css('display','none');
            }
            if (!errors.error?.price_hide_show || errors.error.price_hide_show.length === 0) {
                $(".price_hide_show-error").css('display','none');
            }
            if (!errors.error?.package_book_online || errors.error.package_book_online.length === 0) {
                $(".package_book_online-error").css('display','none');
            }
            if (!errors.error?.package_description || errors.error.package_description.length === 0) {
                $(".package_description-error").css('display','none');
            }


            $("#"+form).find('select[name="' + index + '"]').addClass("is-invalid");
            $("#"+form).find('textarea[name="' + index + '"]').addClass("is-invalid");
            $("."+index+"-error").text(errors.error[index]);
        }
    }else if (await checkStatus(res) ==500 && !errors.status){
        toastr.error(errors.message);
    }
    else if (await checkStatus(res) ==403){
        toastr.error(errors.message);
    }


}


const checkStatus = async (res) =>{
    return await res.status
}

const deleteRecord = async (url,id)=>{
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(async (result) => {
        if (result.isConfirmed) {
            showloader();
            const response = await fetch(url,{
                method:'post',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify({id:id})
            })
            const res = await response.json();
            if(res.status){
                table.draw();
                hideLoader();
                Swal.fire({
                    title: "Deleted!",
                    text: res.message,
                    icon: "success"
                });
            }else{
                hideLoader();
                Swal.fire({
                    title: "Oops...!",
                    text: res.message,
                    icon: "error"
                });

            }
        }
    });
}

const getDestinationUsingCountryId = async (value) =>{
    try {
        showloader();
        const response = await fetch(SITE_URL+'/admin/common/get-destination-by-country-id',{
            method:'post',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            body:JSON.stringify({id:value})
        })
        const res = await response.json();
        let html = `<option value="">Select Destination</option>`;
        res.data.forEach((value)=>{
            html +=`<option value="${value.id}">${value.name}</option>`;
        });
        $("#destination").html('');
        $("#destination").html(html);

        hideLoader();
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
}

const generateSlug = (value,id)=>{
   $("#"+id).val(value.toLowerCase().split(' ').join('-'));
}


const changeStatus = async (url,id,status) => {
    try {
        showloader();
        const response = await fetch(url,{
            method:'post',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            body:JSON.stringify({id:id,status:status})
        })
        const res = await response.json();
        if(res.status){
            table.draw();
            hideLoader();
            toastr.success(res.message)
        }else{
            hideLoader();
            toastr.error(res.message)

        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message)
    }

}

const generateDaysAccordingOFNight = (value,id) =>{
    $("#"+id).val(parseInt(value)+1);
}