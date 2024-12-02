<div>
    <button class="home-btn" onclick="goToHome()">
        <i class="fas fa-home"></i>
    </button>
</div>

<style>
    /* تصميم الزر */

    .home-btn {
        position: fixed;
        top: 10px;
        right: 20px;
        width: 60px;
        height: 60px;
        /*background: linear-gradient(135deg, #7b7d80, #95afcc); !* خلفية متدرجة *!*/
        background: none;
        color: #fdfcfc; /* لون الأيقونة */
        border: none;
        border-radius: 20px 10px 20px 10px; /* نصف دائري من الأعلى ودائري بسيط من الأسفل */
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        /*box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);*/
        transition: all 0.3s ease-in-out; /* تأثير سلس */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        /*z-index: 1000; !* لإظهار الزر فوق العناصر الأخرى *!*/
    }


    /* تحديد الموقع بناءً على اتجاه اللغة */
    html[lang="ar"] .home-btn {

        left: 20px; /* الزر يظهر على اليسار عند اللغة الإنجليزية */
        right: auto;
    }

    html[lang="en"] .home-btn {
        right: 20px; /* الزر يظهر على اليمين عند اللغة العربية */
        left: auto;
    }

    /* تأثير عند التمرير */
    .home-btn:hover {
        /*background: linear-gradient(135deg, #5a5d60, #7b9dbb); !* تغيير التدرج عند التمرير *!*/
        transform: translateY(-6px) scale(1.1); /* رفع الزر قليلاً وتكبيره */
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.25); /* زيادة الظلال */
    }

    .home-btn:active {
        transform: translateY(-2px) scale(1); /* تقليل الحركة عند الضغط */
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); /* تقليل الظلال */
    }

    .home-btn i {
        font-size: 28px; /* حجم الأيقونة */
        transition: transform 0.3s ease, color 0.3s ease; /* تأثير على الأيقونة */
    }

    .home-btn:hover i {
        transform: rotate(360deg); /* دوران الأيقونة عند التمرير */
        color: #d1d1d1; /* لون الأيقونة عند التمرير */
    }

</style>

<script>
    function goToHome() {
        window.location.href = "/home"; // تعديل المسار حسب احتياجاتك
    }
</script>
