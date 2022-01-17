<x-casteachin-layout>
    <script>
        document.addEventListener("DOMContentLoaded", function (event){
            window.axios.get('http://casteaching.test/api/videos').then(function (data){
                console.log(data);
            }).catch(function (error){
                console.log(error);
            })
        });

    </script>
</x-casteachin-layout>
