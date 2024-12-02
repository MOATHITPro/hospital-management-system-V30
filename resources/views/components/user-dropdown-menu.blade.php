<div class="user-menu">
    <div class="user-profile" onclick="toggleDropdown()">
        <!-- أيقونة المستخدم -->
        <i class="fas fa-user-circle user-icon"></i>
    </div>
    <!-- القائمة المنسدلة -->
    <div id="dropdown-menu" class="dropdown-menu">
        <div class="user-info">
            <i class="fas fa-user-circle user-icon-large"></i>
            <div>
                <span class="user-name">{{ $name }}</span>
                <span class="user-email">{{ $email }}</span>
            </div>
        </div>
        <div class="dropdown-options">
            @php
                $type = \App\Services\Login\LoginService::typeOfUser();
                $currentLocale = app()->getLocale();
            @endphp
            @if($type === 'user')
                <a href="/user/previous-visits" class="dropdown-option">
                    <i class="fas fa-history"></i>
                    {{ __('messages.previous_visits') }}
                </a>
                <a href="/user/edit" class="dropdown-option">
                    {{ __('messages.account_settings') }}
                </a>
                <div class="language-selector">
                    <span class="language-title">{{ __('messages.language') }}:</span>
                    <div class="language-options">
                        @if($currentLocale === 'ar')
                            <a href="{{ route('change-language', 'en') }}" class="language-option">
                                <i class="fas fa-globe"></i> English
                            </a>
                        @else
                            <a href="{{ route('change-language', 'ar') }}" class="language-option">
                                <i class="fas fa-globe"></i> العربية
                            </a>
                        @endif
                    </div>
                </div>
            @endif
            <!-- خيار الزيارات السابقة -->

            <!-- اختيار اللغة -->


            <a href="#" class="dropdown-option logout" onclick="goToLogout()">
                {{ __('messages.logout') }}
            </a>
        </div>
    </div>
</div>

<!-- روابط المكتبات CSS -->
<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- روابط المكتبات JS -->
<script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>

<style>
    /* تصميم الأيقونة الخارجية */
    .user-menu {
        position: fixed;
        top: 20px;
        left: 20px; /* الموضع الافتراضي */
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 10px;
        border-radius: 10px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        z-index: 1000;
        margin: 5px;
    }

    /* عند اللغة العربية، يجب تغيير موضع الأيقونة إلى اليمين */
    html[lang="ar"] .user-menu {
        left: auto; /* إزالة الموضع الافتراضي لليسار */
        right: 20px; /* الموضع في الجهة اليمنى */
    }

    /* تصميم الأيقونة */
    .user-icon {
        font-size: 40px;
        background: linear-gradient(135deg, #a6dded, #dce8f7);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-right: 10px;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .user-icon:hover {
        transform: scale(1.2);
        color: #feb47b;
    }

    /* تصميم القائمة المنسدلة */
    .dropdown-menu {
        position: absolute;
        top: 60px;
        left: 0;
        background: linear-gradient(135deg, #ffffff, #f7f7f7);
        border-radius: 12px;
        box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.15);
        width: 350px;
        display: none;
        flex-direction: column;
        padding: 20px;
        transition: opacity 0.3s ease, transform 0.3s ease;
        opacity: 0;
        transform: translateY(-10px);
        z-index: 1050;
    }

    /* عند اللغة العربية، القائمة تتحرك لليمين */
    html[lang="ar"] .dropdown-menu {
        left: auto; /* إزالة الموضع الافتراضي لليسار */
        right: 0; /* الموضع لليمين */
        text-align: right;
    }

    /* عند عرض القائمة */
    .dropdown-menu.show {
        display: flex;
        opacity: 1;
        transform: translateY(0);
    }

    /* تصميم معلومات المستخدم */
    .user-info {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #ececec;
    }

    /* الأيقونة الكبيرة لمعلومات المستخدم */
    .user-info .user-icon-large {
        font-size: 40px;
        color: #ffffff;
        background-color: #444;
        border-radius: 50%;
        padding: 12px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
        margin-right: 10px; /* التباعد من اليمين للغة الإنجليزية */
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    /* عند اللغة العربية، يجب عكس التباعد للأيقونة الكبيرة */
    html[lang="ar"] .user-info .user-icon-large {
        margin-right: 0;
        margin-left: 10px; /* التباعد من اليسار للغة العربية */
    }

    .user-icon-large:hover {
        background-color: #555;
        transform: scale(1.1);
    }

    /* خيارات القائمة */
    .dropdown-options {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .dropdown-option {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        text-decoration: none;
        color: #333;
        font-size: 16px;
        background-color: #ffffff;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    }

    .dropdown-option:hover {
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    /* خيار تسجيل الخروج */
    .logout {
        color: #ff4d4d;
    }

    .logout:hover {
        background-color: #ffe6e6;
        color: #c62828;
    }

    /* اختيار اللغة */
    .language-selector {
        margin-top: 15px;
        padding: 10px;
        background: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    }

    .language-title {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .language-options {
        display: flex;
        gap: 10px;
        justify-content: flex-start;
    }

    .language-option {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #333;
        background-color: #ffffff;
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .language-option:hover {
        background-color: #f5f5f5;
        transform: scale(1.05);
    }

    .language-option i {
        font-size: 16px;
        color: #4CAF50;
    }

    /* تصميم متجاوب */
    /*@media (max-width: 768px) {*/
    /*    .dropdown-menu {*/
    /*        width: 90%;*/
    /*        left: 5%;*/
    /*    }*/

    /*    .dropdown-option {*/
    /*        font-size: 14px;*/
    /*        padding: 10px 12px;*/
    /*    }*/

    /*    .language-option {*/
    /*        font-size: 12px;*/
    /*        padding: 6px 10px;*/
    /*    }*/
    /*}*/

</style>

<script>
    function goToLogout() {
        window.location.href = "/logout";
    }

    function toggleDropdown() {
        var dropdown = document.getElementById('dropdown-menu');
        dropdown.classList.toggle('show');
    }

    window.onclick = function (event) {
        if (!event.target.matches('.user-profile') && !event.target.matches('.user-icon')) {
            var dropdowns = document.getElementsByClassName("dropdown-menu");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
