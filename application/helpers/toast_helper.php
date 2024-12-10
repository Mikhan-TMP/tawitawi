<?php
function getAlertMessages($icon, $message) {
    return '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "' . $icon . '",
                title: ' . json_encode($message) . '
            });
        });
    </script>';
}


// function getAlertDelete($message) {
//     return '<script>
//         document.addEventListener("DOMContentLoaded", function() {
//             Swal.fire({
//             title: "Are you sure?",
//             text: "You won\'t be able to revert this!",
//             icon: "warning",
//             showCancelButton: true,
//             confirmButtonColor: "#3085d6",
//             cancelButtonColor: "#d33",
//             confirmButtonText: "Yes, delete it!"
//             }).then((result) => {
//             if (result.isConfirmed) {
//                 Swal.fire({
//                 title: "Deleted!",
//                 text: "Your file has been deleted.",
//                 icon: "success"
//                 });
//             }
//             });
//         });
//     </script>';
// }