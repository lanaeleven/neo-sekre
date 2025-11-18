<style>
    .animate-slideIn {
        animation: slideIn 0.3s ease-out;
    }

    .animate-slideInRight {
        animation: slideInRight 0.25s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(-100%);
        }

        to {
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }
</style>
