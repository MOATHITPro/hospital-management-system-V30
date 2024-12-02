{{--<div class="notifications-list" id="notificationsList">--}}
{{--    @if($record->isEmpty())--}}
{{--        <p class="no-notifications">No new notifications</p>--}}
{{--    @else--}}
{{--        @foreach($record as $notification)--}}
{{--            <div class="notification-card">--}}
{{--                <div class="notification-icon">--}}
{{--                    <i class="fas fa-info-circle"></i>--}}
{{--                </div>--}}
{{--                <div class="notification-content">--}}
{{--                    <div class="notification-header">--}}
{{--                        <strong class="notification-type">--}}
{{--                            {{ str_replace(["App\\Models\\", "_"], " ", $notification->event_type) }}--}}
{{--                        </strong>--}}
{{--                        <span class="notification-action">{{ ucfirst($notification->action) }}</span>--}}
{{--                    </div>--}}
{{--                    <p class="notification-description">--}}
{{--                        {{ str_replace(["App\\Models\\", "_"], " ", $notification->description) }}--}}
{{--                    </p>--}}
{{--                    <p class="notification-date">--}}
{{--                        {{ \Carbon\Carbon::parse($notification->occurred_at)->format('Y-m-d H:i') }}--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            @if(isset($notification['meta_data']['attributes']))--}}
{{--                <div class="meta-data">--}}
{{--                    <strong>Details:</strong>--}}
{{--                    <ul>--}}
{{--                        @foreach($notification['meta_data']['attributes'] as $key => $value)--}}
{{--                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        @endforeach--}}

{{--    @endif--}}
{{--</div>--}}

{{--<!-- Custom Pagination -->--}}
{{--<div class="custom-pagination">--}}
{{--    @if ($record->onFirstPage())--}}
{{--        <span class="pagination-link disabled">&laquo; First</span>--}}
{{--        <span class="pagination-link disabled">&lsaquo; Prev</span>--}}
{{--    @else--}}
{{--        <button id="page" onclick="fetchRecords('{{ $record->url(1) }}')" class="pagination-link">&laquo; First</button>--}}
{{--        <button id="page" onclick="fetchRecords('{{ $record->previousPageUrl() }}')" class="pagination-link">&lsaquo; Prev</button>--}}
{{--    @endif--}}

{{--    @foreach ($record->getUrlRange(max(1, $record->currentPage() - 2), min($record->lastPage(), $record->currentPage() + 2)) as $page => $url)--}}
{{--        <button id="page" onclick="fetchRecords('{{ $url }}')" class="pagination-link {{ $page == $record->currentPage() ? 'active' : '' }}">{{ $page }}</button>--}}
{{--    @endforeach--}}

{{--    @if ($record->hasMorePages())--}}
{{--        <button id="page" onclick="fetchRecords('{{ $record->nextPageUrl() }}')" class="pagination-link">Next &rsaquo;</button>--}}
{{--        <button id="page" onclick="fetchRecords('{{ $record->url($record->lastPage()) }}')" class="pagination-link">Last &raquo;</button>--}}
{{--    @else--}}
{{--        <span class="pagination-link disabled">Next &rsaquo;</span>--}}
{{--        <span class="pagination-link disabled">Last &raquo;</span>--}}
{{--    @endif--}}
{{--</div>--}}


{{--<!-- Styles for Notifications and Pagination -->--}}
{{--<style>--}}
{{--    /* Notifications Styling */--}}
{{--    .notifications-list {--}}
{{--        display: flex;--}}
{{--        flex-direction: column;--}}
{{--        gap: 15px;--}}
{{--        margin-top: 20px;--}}
{{--        font-family: 'Poppins', sans-serif;--}}
{{--    }--}}

{{--    .no-notifications {--}}
{{--        text-align: center;--}}
{{--        font-size: 1rem;--}}
{{--        color: #888;--}}
{{--    }--}}

{{--    .notification-card {--}}
{{--        display: flex;--}}
{{--        align-items: flex-start;--}}
{{--        gap: 15px;--}}
{{--        padding: 15px;--}}
{{--        background-color: #f9f9f9;--}}
{{--        border-radius: 8px;--}}
{{--        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);--}}
{{--    }--}}

{{--    .notification-icon {--}}
{{--        color: #3490dc;--}}
{{--        font-size: 1.5rem;--}}
{{--    }--}}

{{--    .notification-content {--}}
{{--        flex: 1;--}}
{{--    }--}}

{{--    .notification-header {--}}
{{--        display: flex;--}}
{{--        justify-content: space-between;--}}
{{--        align-items: center;--}}
{{--        margin-bottom: 5px;--}}
{{--    }--}}

{{--    .notification-type {--}}
{{--        font-weight: bold;--}}
{{--        color: #333;--}}
{{--    }--}}

{{--    .notification-action {--}}
{{--        font-size: 0.9rem;--}}
{{--        color: #777;--}}
{{--    }--}}

{{--    .notification-description {--}}
{{--        margin: 5px 0;--}}
{{--        color: #555;--}}
{{--    }--}}

{{--    .notification-date {--}}
{{--        font-size: 0.85rem;--}}
{{--        color: #aaa;--}}
{{--    }--}}

{{--    /* Custom Pagination Styling */--}}
{{--    .custom-pagination {--}}
{{--        display: flex;--}}
{{--        justify-content: center;--}}
{{--        gap: 5px;--}}
{{--        margin-top: 20px;--}}
{{--        padding: 10px;--}}
{{--        font-family: 'Poppins', sans-serif;--}}
{{--    }--}}

{{--    .pagination-link {--}}
{{--        padding: 8px 12px;--}}
{{--        font-size: 0.9rem;--}}
{{--        color: #007bff;--}}
{{--        background-color: #fff;--}}
{{--        border: 1px solid #ddd;--}}
{{--        border-radius: 4px;--}}
{{--        text-decoration: none;--}}
{{--        transition: background-color 0.3s ease, color 0.3s ease;--}}
{{--    }--}}

{{--    .pagination-link.active {--}}
{{--        background-color: #007bff;--}}
{{--        color: #fff;--}}
{{--        font-weight: bold;--}}
{{--    }--}}

{{--    .pagination-link:hover:not(.active) {--}}
{{--        background-color: #e0e7ff;--}}
{{--        color: #0056b3;--}}
{{--    }--}}

{{--    .pagination-link.disabled {--}}
{{--        color: #ccc;--}}
{{--        pointer-events: none;--}}
{{--    }--}}
{{--    .meta-data {--}}
{{--        margin-top: 10px;--}}
{{--        padding: 10px;--}}
{{--        background-color: #f1f1f1;--}}
{{--        border-left: 3px solid #007bff;--}}
{{--        border-radius: 5px;--}}
{{--        font-size: 0.9rem;--}}
{{--        color: #555;--}}
{{--    }--}}

{{--    .meta-data strong {--}}
{{--        font-weight: bold;--}}
{{--        color: #333;--}}
{{--    }--}}

{{--    .meta-data-list {--}}
{{--        margin: 5px 0 0;--}}
{{--        padding-left: 20px;--}}
{{--        list-style-type: disc;--}}
{{--    }--}}

{{--    .meta-data-list li {--}}
{{--        margin-bottom: 5px;--}}
{{--    }--}}

{{--</style>--}}


{{--<!-- Styles for Meta Data -->--}}
{{--<style>--}}
{{--    .meta-data {--}}
{{--        margin-top: 10px;--}}
{{--        padding: 10px;--}}
{{--        background-color: #f1f1f1;--}}
{{--        border-left: 3px solid #007bff;--}}
{{--        border-radius: 5px;--}}
{{--        font-size: 0.95rem;--}}
{{--        color: #333;--}}
{{--    }--}}

{{--    .meta-data strong {--}}
{{--        font-weight: bold;--}}
{{--        color: #333;--}}
{{--    }--}}

{{--    .meta-data-list {--}}
{{--        margin: 5px 0 0;--}}
{{--        padding-left: 20px;--}}
{{--        list-style-type: disc;--}}
{{--    }--}}

{{--    .meta-data-list li {--}}
{{--        margin-bottom: 5px;--}}
{{--    }--}}

{{--    .meta-data-list li strong {--}}
{{--        color: #000;--}}
{{--    }--}}
{{--</style>--}}

{{--<script>--}}
{{--    updateNotificationCount({{$count_notification}});--}}
{{--</script>--}}
<div id="notificationsPage" class="min-h-screen flex items-center justify-center py-10">
    <div class="glass-container max-w-5xl w-full mx-auto">

        <!-- إذا لم يكن هناك إشعارات -->
        <div class="no-notifications-wrapper" style="display: {{ $record->isEmpty() ? 'block' : 'none' }}">
            <img src="/images/no-notifications.png" alt="No Notifications" class="no-notifications-image">
            <p class="no-notifications">You have no new notifications</p>
        </div>

        <!-- إذا كانت هناك إشعارات -->
        <div class="space-y-6">
            @foreach($record as $notification)
                <div class="statistics-notification-card {{ !$notification->viewed ? 'new-notification' : '' }}" data-aos="fade-up">
                    <div class="statistics-content">
                        <!-- رأس البطاقة -->
                        <div class="statistics-header">
                            <div class="statistics-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="statistics-info">
                                <strong class="statistics-type">
                                    {{ str_replace(["App\\Models\\", "_"], " ", $notification->event_type) }}
                                </strong>
                                <span class="statistics-date">
                                {{ \Carbon\Carbon::parse($notification->occurred_at)->format('Y-m-d H:i') }}
                            </span>
                            </div>
                        </div>

                        <!-- الوصف -->
                        <p class="statistics-description">
                            {{ str_replace(["App\\Models\\", "_"], " ", $notification->description) }}
                        </p>

                        <!-- البيانات الوصفية -->
                        @if(isset($notification['meta_data']['attributes']))
                            <div class="meta-data">
                                <div class="meta-data-grid">
                                    @foreach($notification['meta_data']['attributes'] as $key => $value)
                                        <div class="meta-data-item">
                                            <strong>{{ ucfirst($key) }}:</strong> {{ $value }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="statistics-footer">
                            <button class="mark-as-read-btn" onclick="markAsRead('{{ $notification->id }}')">Mark as Read</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Custom Pagination -->
        <div class="custom-pagination">
            @if ($record->onFirstPage())
                <span class="pagination-link disabled">&laquo; First</span>
                <span class="pagination-link disabled">&lsaquo; Prev</span>
            @else
                <button id="page" onclick="fetchRecords('{{ $record->url(1) }}')" class="pagination-link">&laquo; First</button>
                <button id="page" onclick="fetchRecords('{{ $record->previousPageUrl() }}')" class="pagination-link">&lsaquo; Prev</button>
            @endif

            @foreach ($record->getUrlRange(max(1, $record->currentPage() - 2), min($record->lastPage(), $record->currentPage() + 2)) as $page => $url)
                <button id="page" onclick="fetchRecords('{{ $url }}')" class="pagination-link {{ $page == $record->currentPage() ? 'active' : '' }}">{{ $page }}</button>
            @endforeach

            @if ($record->hasMorePages())
                <button id="page" onclick="fetchRecords('{{ $record->nextPageUrl() }}')" class="pagination-link">Next &rsaquo;</button>
                <button id="page" onclick="fetchRecords('{{ $record->url($record->lastPage()) }}')" class="pagination-link">Last &raquo;</button>
            @else
                <span class="pagination-link disabled">Next &rsaquo;</span>
                <span class="pagination-link disabled">Last &raquo;</span>
            @endif
        </div>
    </div>
</div>


<!-- Styles for Full-Width Notifications with Transparent Backgrounds -->
<style>
    /*!* خلفية زجاجية للحاوية *!*/
    /*.glass-container {*/
    /*    background: rgba(255, 255, 255, 0.1); !* شفافية أكبر *!*/
    /*    backdrop-filter: blur(20px);*/
    /*    border-radius: 20px;*/
    /*    border: 1px solid rgba(255, 255, 255, 0.25);*/
    /*    padding: 30px;*/
    /*    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);*/
    /*}*/

    /*!* العنوان *!*/
    /*.section-title-custom {*/
    /*    font-size: 2.5rem;*/
    /*    font-weight: bold;*/
    /*    color: #fff; !* النص الأبيض يبرز أكثر مع الخلفية الشفافة *!*/
    /*    text-align: center;*/
    /*    margin-bottom: 30px;*/
    /*}*/

    /* تصميم البطاقة */
    .statistics-notification-card {
        background: rgba(255, 255, 255, 0.1); /* شفافية أكبر */
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        padding: 20px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .statistics-notification-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .statistics-notification-card.new-notification::before {
        content: "New";
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: rgba(231, 76, 60, 0.8); /* خلفية شفافة للشريط */
        color: #fff;
        padding: 5px 10px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: bold;
    }

    /* رأس البطاقة */
    .statistics-header {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .statistics-icon {
        font-size: 2rem;
        color: #00d1ff;
    }

    .statistics-info {
        display: flex;
        flex-direction: column;
    }

    .statistics-type {
        font-weight: bold;
        font-size: 1.2rem;
        color: #fff;
    }

    .statistics-date {
        font-size: 0.9rem;
        color: #fdffff;
    }

    /* الوصف */
    .statistics-description {
        font-size: 1rem;
        color: #eaeaea;
        line-height: 1.5;
    }

    /* البيانات الوصفية */
    .meta-data {
        padding: 10px;
        background-color: rgba(240, 248, 255, 0.2); /* شفافية للبيانات الوصفية */
        border-radius: 8px;
        font-size: 0.9rem;
        color: #fff;
    }

    .meta-data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
    }

    .meta-data-item {
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.1); /* خلفية شفافة */
        border-radius: 6px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
        color: #fff;
    }

    /* تذييل البطاقة */
    .statistics-footer {
        display: flex;
        justify-content: flex-end;
    }

    .mark-as-read-btn {
        padding: 8px 15px;
        background-color: rgba(41, 128, 185, 0.8); /* خلفية شفافة للزر */
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .mark-as-read-btn:hover {
        background-color: rgba(31, 97, 141, 0.9);
        transform: scale(1.05);
    }

    /* لا توجد إشعارات */
    .no-notifications-wrapper {
        text-align: center;
        color: #fff;
    }

    .no-notifications-image {
        width: 150px;
        margin-bottom: 15px;
    }

    .no-notifications {
        font-size: 1.4rem;
        color: #fff;
        font-weight: 600;
    }
    /* شريط التنقل */
    .custom-pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
        padding: 10px 0;
    }

    .pagination-link {
        padding: 10px 15px;
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pagination-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .pagination-link.active {
        background-color: rgba(41, 128, 185, 0.8);
        color: #fff;
        cursor: default;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .pagination-link.disabled {
        background-color: rgba(255, 255, 255, 0.05);
        color: #bbb;
        cursor: not-allowed;
    }


</style>

<script>
        updateNotificationCount({{$count_notification}});

</script>
