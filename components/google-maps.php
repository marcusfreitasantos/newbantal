<?php 
function GoogleMaps(){ ?>
<?php 
$googleApiKey = GOOGLE_MAPS_API_KEY; 
$childThemeDirectory = get_stylesheet_directory_uri();
$defaultUserAvatar = "$childThemeDirectory/assets/img/favicon.png";
?>

    <!-- prettier-ignore -->
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "<?= $googleApiKey; ?>", v: "weekly"});</script>

    <script>
        let currentUserLat = 0;
        let currentUserLong = 0;

        if ("geolocation" in navigator)
        navigator.geolocation.getCurrentPosition((position) => {
            currentUserLat = position.coords.latitude;
            currentUserLong = position.coords.longitude;
            initMap();
        });

        async function getAllUsers() {
        try {
            const allUsers = await callAjaxGetUsers();
            return allUsers;
        } catch (error) {
            console.error("Error fetching users:", error);
        }
        }

        async function initMap() {
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
            "marker"
        );

        let map = new Map(document.getElementById("bantal__custom_map"), {
            center: { lat: currentUserLat, lng: currentUserLong },
            zoom: 14,
            mapId: "bantal__custom_map",
            disableDefaultUI: true,
        });

        const currentUserPin = new PinElement({
            scale: 2,
            background: "#f0903a",
            borderColor: "#f0903a",
        });

        const marker = new AdvancedMarkerElement({
            map,
            position: { lat: currentUserLat, lng: currentUserLong },
            content: currentUserPin.element,
            zIndex: 5
        });

        const allUsers = await getAllUsers();

        const buildContent = (userAvatar) => {
            const bantalUsersAvatar = document.createElement("div");
            bantalUsersAvatar.innerHTML = `
            <div class='bantal__map_user_avatar_wrapper'>
                <img src='${userAvatar}' />
            </div>
            `
            return bantalUsersAvatar;
        }

            allUsers.map((bantalUser) => {
                if (bantalUser.latitude && bantalUser.longitude) {
                    const avatarBase64Url = `data:image/png; base64, ${bantalUser.photo}`;

                    const bantalUserMarker = new AdvancedMarkerElement({
                        map,
                        position: {
                        lat: Number(bantalUser.latitude),
                        lng: Number(bantalUser.longitude),
                        },
                        content: buildContent(bantalUser.photo ? avatarBase64Url : "<?= $defaultUserAvatar; ?>")
                    });

                    bantalUserMarker.addListener("click", ({ domEvent, latLng }) => {
                        const { target } = domEvent;
                        window.location.href =
                        "https://recrutamento.bantal.com.br/recrutamento";
                    });
                }
            });
        }
    </script>

    <div id="bantal__custom_map" style="height: 600px"></div>
<?php }
