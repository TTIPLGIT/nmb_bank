<style>
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: whitesmoke;
        /* border: 1px solid rgba(26, 54, 126, .125);
        border-radius: 0.25rem;
        margin-top: 10px;
        margin-bottom: 10px; */
        text-align: center;
        margin: 10px;
        /* height: 94%; */
    }

    .cardheight {
        height: 94%;

    }

    .contentpadding {
        padding-top: 10px;
      
    }

    .cardlength {
        height: fit-content;
    }

    .lengthcard {
        height: 211px;



    }

    .headercolor {
        color: #5263dd;
    }

    .fontsweight {
        font-weight: bold;
    }

    .fontsizes {
        font-size: 1rem;
    }

    .numberfontsize {
        font-size: 1.1rem;
        font-weight: bold;
    }

    .newcolor {
        color: #6b747b;
    }

    .borderline {
        border-left: 7px solid #4e73df;
        border-radius: 5px;
    }

    .borderstatic {
        border-left: 7px solid #1cc88a;
        border-radius: 5px;
    }

    .borderstyle {
        border-left: 7px solid #e74a3b;
        border-radius: 5px;
    }

    .bordercolors {
        border-left: 7px solid #f6c23e;
        border-radius: 5px;
    }

    .chartspace {
        overflow-x: auto;
    }

    #scroll {
        padding: 20px !important;
    }

    .card-body {
        background: rgb(0, 111, 251, 0.4);
    }

    .fontsize {
        font-size: 15px;
    }

    .colorgrey {
        color: #636b6f;
    }

    .card-body,
    .card-footer {
        padding: 0 !important;
    }

    .card-header {
        /* background-color: #2BDC7C; */
        font-size: 16px;
        font-weight: bold;
    }

    .card.mb-3 {
        margin-bottom: 10px !important;
    }

    .li {
        background-color: #62acde;
    }

    .li.div {
        float: left;
    }

    #sub {
        margin-top: 35px;
    }

    li.list-group-item.d-flex.justify-content-between.align-items-center.flex-wrap {
        background: #ffffff;
    }

    a {
        font-size: small;
    }

    #fa-icon {
        color: #0000FF !important;
        padding-right: 0.3rem;
    }

    #row3 {
        padding-bottom: 25px !important;
    }
</style>

<style>
    .profile-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        margin: 10px;
        /* box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.2); */
        background-color: #8acef2;

    }

    .profile-photo-wrapper {
        width: 80px;
        height: 80px;
        overflow: hidden;
        border-radius: 50%;
        margin-bottom: 16px;
        margin-top: 10px;
    }

    #profile {
        width: 100%;
        height: 100%;
        object-fit: cover;
        top: 25%;
    }

    .profile-text,
    .profile-subtext {
        font-size: 12px;
        line-height: 16px;
        color: var(--secondary-color);
        margin: 0 0 8px 0;
    }

    .section-body {
        margin-top: 3rem;
        width: 100%;
    }

    .charts {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile-text {
        font-weight: 600;
    }
</style>

<style>
    #dashboard {
        max-width: 100%;
        padding-top: 10px;
        padding-bottom: 20px;
        overflow-x: hidden;
        /* flex-wrap: unset;
        padding: 10px;
        padding-top: 10px;
        padding-bottom: 10px; */
    }

    .bg {
        /* background-image: linear-gradient(-20deg, #2b5876 0%, #294e98 100%) !important; */
        background-color: #36b9cc;
    }

    .widget-content {
        padding: 1rem;
        flex-direction: row;
        align-items: center;
    }

    .widget-content .widget-content-wrapper {
        display: flex !important;
        flex: 10 !important;
        position: relative;
        align-items: center;
        flex-direction: row;
        flex-wrap: wrap;
        align-content: stretch;
        justify-content: space-between;
    }

    .widget-content-right {
        text-align: right;
    }
</style>

<style>
    .title {
        color: grey;
        font-size: 18px;
    }

    #divider {
        border-top: 1.3px solid darkgray;
        width: 277px;
        text-align: center;
        margin-bottom: 10px;
    }
</style>

<style>
    .stati {
        background: #fff;
        height: 6em;
        padding: 1em;
        margin: 1em 0;
        -webkit-transition: margin 0.5s ease, box-shadow 0.5s ease;
        transition: margin 0.5s ease, box-shadow 0.5s ease;
        -moz-box-shadow: 0px 0.2em 0.4em rgb(0, 0, 0, 0.8);
        -webkit-box-shadow: 0px 0.2em 0.4em rgb(0, 0, 0, 0.8);
        box-shadow: 0px 0.2em 0.4em rgb(0, 0, 0, 0.8);
    }

    .stati:hover {
        margin-top: 0.5em;
        -moz-box-shadow: 0px 0.4em 0.5em rgb(0, 0, 0, 0.8);
        -webkit-box-shadow: 0px 0.4em 0.5em rgb(0, 0, 0, 0.8);
        box-shadow: 0px 0.4em 0.5em rgb(0, 0, 0, 0.8);
    }

    .stati i {
        font-size: 3.5em;
    }

    .stati div {
        width: calc(100% - 3.5em);
        display: block;
        text-align: right;
    }

    .stati div b {
        font-size: 2.2em;
        width: 100%;
        padding-top: 0px;
        margin-top: -0.2em;
        margin-bottom: -0.2em;
        display: block;
        color: white;
        margin-left: 50px;

    }

    .stati div span {
        font-size: 1em;
        width: 100%;
        color: white;
        display: block;
        margin-left: 50px;

    }

    .stati.bg-turquoise {
        /* height: 100px; */
        background: #fff;
        color: green;
    }

    a {
        color: none;
        cursor: pointer;
    }

    a:hover {
        text-decoration: none;
    }
</style>

<style>
    .scrollable,
    #scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
        height: 300px;
        display: flex;
        flex-direction: column;
        overflow-y: scroll;
    }

    #scrollq {
        -ms-overflow-style: none;
        scrollbar-width: none;
        height: 180px;
        display: flex;
        flex-direction: column;
        overflow-y: scroll;
    }

    .scrollable::-webkit-scrollbar {
        display: none;
    }
</style>

<style>
    table {
        text-align: left;
        position: relative;
        border-collapse: collapse;
    }

    th,
    td {
        margin: 0;

    }

    .table:not(.table-sm) thead th {
        border-bottom: 0;
        color: #fff;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    table.table-bordered {
        border: 1px solid white !important;
        margin-top: 0px;
    }

    th {
        background: #62acde;
        position: sticky;
        top: 0;
        margin: 0 !important;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }
</style>
<style>
    .round-button {
        width: 30px;
        height: 30px;
        line-height: 30px;
        border: 2px solid #f5f5f5;
        border-radius: 50%;
        color: #f5f5f5;
        text-decoration: none;
        box-shadow: 0 0 3px gray;
        font-weight: bold;
        font-size: 20px;
        padding: 1px;
    }

    .round-button:hover {
        background: #777555;
    }

    .dbox__title {
        color: #dee2e6;
    }

    #piechart {
        width: 100%;
        height: 100%;
        text-align: center
    }
</style>
<style>
    @media (min-width:320px) {
        .card {
            margin: 0px !important;
            margin-bottom: 10px !important;
        }
    }
</style>