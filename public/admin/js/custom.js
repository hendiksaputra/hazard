$(document).ready(function(){
    // Check admin password is correct or not
    $("#current_password").keyup(function() {
        var current_password = $("#current_password").val();
        //alert(current_pwd);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/check-current-password',
            data:{current_password:current_password},
            success:function(resp){
                if(resp=="false"){
                    $("#verifyCurrentPassword").html("<font color='red'>Current Password is incorrect</font>");
                } else if(resp=="true"){
                    $("#verifyCurrentPassword").html("<font color='green'>Current Password is correct</font>");
                }
            },error:function(){
                alert("Error");
            }
        })
    });

    // update cms status
    $(document).on("click", ".updateCmsStatus", function(){
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-cms-status',
            data:{status:status, page_id:page_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#page-"+page_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
                } else if(resp['status']==1){
                    $("#page-"+page_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert("Error");
            }
        })
    })

     // update subadmin status
     $(document).on("click", ".updateSubadminStatus", function(){
        var status = $(this).children("i").attr("status");
        var subadmin_id = $(this).attr("subadmin_id");


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-subadmin-status',
            data:{status:status, subadmin_id:subadmin_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#subadmin-"+subadmin_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
                } else if(resp['status']==1){
                    $("#subadmin-"+subadmin_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
            },error:function(){
                alert("Error");
            }
        })
    })

    //confirm the deletion of cms page
    // $(document).on("click", ".confirmDelete", function(){
    //    var name = $(this).attr("name");
    //    if(confirm("Are you sure you want to delete this "+name+"?")) {
    //        return true;
    //    }
    //    return false;
    // });

    //confirm the deletion of cms page with sweetalert
    $(document).on("click", ".confirmDelete", function(){
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
              });
              window.location.href = "/admin/delete-"+record+"/"+recordid;
            }
           
          });
    });   

});  