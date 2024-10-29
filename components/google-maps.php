<?php 
function GoogleMaps(){ ?>
<?php 
$googleApiKey = GOOGLE_MAPS_API_KEY; 

?>

    <!-- prettier-ignore -->
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "<?= $googleApiKey; ?>", v: "weekly"});</script>



    <script>
        let currentUserLat = 0;
        let currentUserLong = 0;

        if("geolocation" in navigator)
        
        navigator.geolocation.getCurrentPosition((position) => {
            currentUserLat = position.coords.latitude;
            currentUserLong = position.coords.longitude;
            initMap();
        });

        async function initMap() {
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            let map = new Map(document.getElementById("bantal__custom_map"), {
                center: { lat: currentUserLat, lng: currentUserLong },
                zoom: 15,
                mapId: "bantal__custom_map",
            });

            const marker = new AdvancedMarkerElement({
                map,
                position: { lat: currentUserLat, lng: currentUserLong },
            });

              marker.addListener('click', ({domEvent, latLng}) => {
                    const {target} = domEvent;
                    alert(`Suas coordenaadas são: ${currentUserLat} , ${currentUserLong}`)
                });
        }

        


    </script>


    <div id="bantal__custom_map" style="height: 600px"></div>
<?php } ?>




