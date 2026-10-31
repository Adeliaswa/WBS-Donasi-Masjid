
/* =========================================
   ADMIN MOBILE HEADER
========================================= */

.admin-mobile-header {
    display: none;
}

@media (max-width: 768px) {

    .admin-mobile-header {
        position: sticky;
        top: 0;
        z-index: 900;

        display: flex;
        align-items: center;
        gap: 12px;

        width: 100%;
        min-height: 64px;
        padding: 10px 17px;

        background: #ffffff;
        border-bottom: 1px solid #e9ede9;
    }

    .admin-sidebar-toggle {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 39px;
        height: 39px;
        flex-shrink: 0;

        padding: 0;
        border: 1px solid #e9ede9;
        border-radius: 10px;

        background: #f1f7f1;
        color: #294236;

        cursor: pointer;
    }

    .admin-sidebar-toggle svg {
        width: 20px;
        height: 20px;
    }

    .admin-mobile-header__identity {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .admin-mobile-header__title {
        color: #1b2b23;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.4;
    }

    .admin-mobile-header__subtitle {
        color: #7e7e7e;
        font-size: 10px;
        font-weight: 500;
    }
}
