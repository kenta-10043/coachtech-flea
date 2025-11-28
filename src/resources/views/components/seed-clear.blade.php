@if ($seedRefreshed)
    <script>
        console.log("Seeder 実行後なので localStorage を初期化します");
        localStorage.clear();
    </script>
@endif
