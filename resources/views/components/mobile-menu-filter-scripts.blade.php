<script>
    document.getElementById('openMenu').onclick = () => {
        document.getElementById('mobileSidebar').classList.remove('hidden');
    };
    document.getElementById('mobileSidebar').onclick = (e) => {
        if (e.target.id === 'mobileSidebar')
            document.getElementById('mobileSidebar').classList.add('hidden');
    };

    document.getElementById('openFilter').onclick = () =>
        document.getElementById('filterDrawer').classList.remove('hidden');

    document.getElementById('closeFilter').onclick = () =>
        document.getElementById('filterDrawer').classList.add('hidden');

    document.getElementById('filterDrawer').onclick = (e) => {
        if (e.target.id === 'filterDrawer')
            document.getElementById('filterDrawer').classList.add('hidden');
    };
</script>
