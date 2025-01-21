<div
    x-data="{open:false}"
    x-show="open"
    @sweet-toast.window="
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        }).fire({
            icon: event.detail.icon,
            title: event.detail.title,
        })
    "
>
</div>
