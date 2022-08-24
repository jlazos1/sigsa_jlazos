<div class="loader-page"></div>

<script>
    $(window).on('load', function() {
        $(".loader-page").css({
            visibility: "hidden",
            opacity: "0.5"
        });
    });

    function imagen() {
        $(".loader-page").css({
            visibility: "hidden",
            opacity: "0.5"
        });
    }
</script>

<style>
    .loader-page {
        position: fixed;
        z-index: 25000;
        opacity: 0.5;
        background: rgb(255, 255, 255);
        left: 0px;
        top: 0px;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .3s ease;
    }

    .loader-page::before {
        content: "";
        position: absolute;
        border: 2px solid rgb(50, 150, 176);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        box-sizing: border-box;
        border-left: 2px solid rgba(50, 150, 176, 0);
        border-top: 2px solid rgba(50, 150, 176, 0);
        animation: rotarload 1s linear infinite;
        transform: rotate(0deg);
    }

    @keyframes rotarload {
        0% {
            transform: rotate(0deg)
        }

        100% {
            transform: rotate(360deg)
        }
    }

    .loader-page::after {
        content: "";
        position: absolute;
        border: 2px solid rgba(50, 150, 176, .5);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        box-sizing: border-box;
        border-left: 2px solid rgba(50, 150, 176, 0);
        border-top: 2px solid rgba(50, 150, 176, 0);
        animation: rotarload 1s ease-out infinite;
        transform: rotate(0deg);
    }

</style>
