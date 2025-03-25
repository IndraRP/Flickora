<nav class="navbar navbar-custom d-lg-none">
    <div class="container-fluid">
        <ul class="navbar-nav d-flex justify-content-around w-100 flex-row">
            <li class="nav-item text-center">
                <a class="nav-link" href="/chatify" id="chatLink">
                    <img id="chatLogo" src="{{ asset("storage/images/logo3.png") }}" style="width: 20px; height:20px; margin-bottom: 5px;">
                    <p class="nav-text text-pri">Obrolan</p>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="/" id="pageLink">
                    <i class="fa-solid fa-user-tag"></i>
                    <p class="nav-text">Laman</p>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="/group" id="groupLink">
                    <i class="fa-solid fa-user-group"></i>
                    <p class="nav-text">Grup</p>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="/lock" id="lockLink">
                    <i class="fa-solid fa-user-lock"></i>
                    <p class="nav-text">Privat</p>
                </a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link" href="/bio" id="bioLink">
                    <i class="bi bi-person-fill mb-0" style="font-size: 23px;"></i>
                    <p class="nav-text" style="margin-top: -2px; margin-bottom: 5px;">Bio</p>
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .navbar-custom {
        background-color: #23272f;
        padding: 0;
        border-radius: 20px 20px 0 0;
        position: fixed;
        bottom: 0;
        width: 100%;
        box-shadow: 0px -2px 10px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .navbar-nav {
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 100%;
        padding: 1px 0;
    }

    .nav-item {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #596170;
        text-decoration: none;
        font-size: 12px;
        transition: color 0.3s, transform 0.3s;
    }

    .nav-link i {
        font-size: 16px;
        transition: transform 0.3s, color 0.3s;
        margin-bottom: 8px;
    }

    .nav-link.active {
        color: #ffffff;
    }

    .nav-link.active p {
        margin-top: 2px;
        color: #ffffff;
    }

    .nav-link.active i {
        color: #ffffff;
        transform: scale(1.1);
    }

    .nav-text {
        font-size: 10px;
        margin: 0;
        line-height: 1;
        transition: color 0.3s;
    }

    @media (min-width: 768px) {
        .navbar-custom {
            display: none;
        }
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;

        const links = [{
                path: '/chatify',
                id: 'chatLink'
            },
            {
                path: '/',
                id: 'pageLink'
            },
            {
                path: '/group',
                id: 'groupLink'
            },
            {
                path: '/lock',
                id: 'lockLink'
            },
            {
                path: '/bio',
                id: 'bioLink'
            }
        ];

        // Menambahkan kelas active pada link yang sesuai
        links.forEach(link => {
            const element = document.getElementById(link.id);
            element.classList.remove('active');
            if (currentPath === link.path) {
                element.classList.add('active');
            }
        });

        // Ganti logo di /chatify
        const chatLogo = document.getElementById('chatLogo');
        if (currentPath === '/chatify') {
            chatLogo.src = "{{ asset("storage/images/logo2.png") }}";
        } else {
            chatLogo.src = "{{ asset("storage/images/logo3.png") }}";
        }
    });
</script>


{{-- DISABLE RIGHT CLICK  --}}
{{-- 
    <script>
        var isNS = (navigator.appName == "Netscape") ? 1 : 0;

        if (navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN || Event.MOUSEUP);

        function mischandler() {
            return false;
        }

        function mousehandler(e) {
            var myevent = (isNS) ? e : event;
            var eventbutton = (isNS) ? myevent.which : myevent.button;
            if ((eventbutton == 2) || (eventbutton == 3)) return false;
        }
        document.oncontextmenu = mischandler;
        document.onmousedown = mousehandler;
        document.onmouseup = mousehandler;
    </script> --}}
