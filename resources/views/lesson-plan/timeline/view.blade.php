<style>

    html{
        scroll-behavior: smooth;
    }
    ::selection{
        color: #fff;
        background: #3ea0e2;
    }
    .wrapper{
        max-width: 1080px;
        position: relative;
    }
    .wrapper .center-line{
        position: absolute;
        height: 100%;
        width: 4px;
        background: #28478a;
        transform: translateX(-50%);
    }
    .wrapper .row{
        display: flex;
    }
    .wrapper .row-1{
        justify-content: flex-start;
    }
    .wrapper .row-2{
        justify-content: flex-start;
    }
    .wrapper .row section{
        background: #fff;
        border-radius: 5px;
        width: calc(50% - 40px);
        padding: 20px;
        left: 5%;
        margin-top: 20px;
        position: relative;
    }
    .wrapper .row section#last{
        background: transparent;
    }
    .wrapper .row section#last::before{
        background: transparent;
    }
    .wrapper .row section::before{
        position: absolute;
        content: "";
        height: 15px;
        width: 15px;
        background: #fff;
        top: 28px;
        z-index: -1;
        transform: rotate(45deg);
    }
    .row-1 section::before{
        right: -7px;
    }
    .row-2 section::before{
        left: -7px;
    }
    .row section .icon,
    .center-line .scroll-icon{
        position: absolute;
        background: #f2f2f2;
        height: 40px;
        width: 40px;
        text-align: center;
        line-height: 40px;
        border-radius: 50%;
        color: #28478a;
        font-size: 17px;
        box-shadow: 0 0 0 4px #fff, inset 0 2px 0 rgba(0,0,0,0.08), 0 3px 0 4px rgba(0,0,0,0.05);
    }
    .center-line .scroll-icon{
        bottom: 0px;
        left: 50%;
        font-size: 25px;
        transform: translateX(-50%);
    }
    .row-1 section .icon{
        top: 15px;
        right: -60px;
    }
    .row-2 section .icon{
        top: 15px;
        left: -60px;
    }
    .row section .details,
    .row section .bottom{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .row section .details .title{
        font-size: 15px;
        font-weight: 600;
    }
    .row section .details .date{
        font-size: 12px;
        font-weight: 400;
    }
    .row section p{
        margin: 10px 0 17px 0;
    }
    .row section .bottom a{
        text-decoration: none;
        background: #3ea0e2;
        color: #fff;
        padding: 7px 15px;
        border-radius: 5px;
        font-weight: 400;
        transition: all 0.3s ease;
    }
    .row section .bottom a:hover{
        transform: scale(0.97);
    }
    @media(max-width: 790px){
        .wrapper .center-line{
            left: 40px;
        }
        .wrapper .row{
            margin: 30px 0 3px 60px;
        }
        .wrapper .row section{
            width: 100%;
        }
        .row-1 section::before{
            left: -7px;
        }
        .row-1 section .icon{
            left: -60px;
        }
    }

    /* CSS for tablets */
    @media screen and (min-width: 768px) and (max-width: 1024px) {
        .row-2 {
            margin-left: 1%;
        }
    }


    @media screen and (max-width: 790px) {
        .wrapper .row {
            margin: 30px 0 3px 50px;
        }
    }

    @media screen and (max-width: 767px) {
        .wrapper .center-line {
            left: 0;
        }
        .wrapper .row {
            margin: 30px 0 3px 30px;
        }
    }

</style>
    <div class="wrapper">
        <div class="center-line">
            <a href="#" class="scroll-icon"><i class="fas fa-caret-up"></i></a>
        </div>
        <div class="row row-2">
            <section>
                <i class="icon fas fa-home"></i>
                <div class="details">
                    <span class="title">Lesson Plan Created</span>
                    <span class="date">{{ $lesson->created_at->format('d F Y') }}</span>
                </div>
            </section>
        </div>

        @foreach ($logs as $log)
            <div class="row row-2">
                <section>
                    <i class="icon fas fa-cog"></i>
                    <div class="details">
                        <span class="title">{{ $log->action }}</span>
                        <span class="date">{{ $log->created_at->format('d F Y') }}</span>
                    </div>
                    <!-- <p>Lorem ipsum dolor sit ameters consectetur adipisicing elit. Sed qui veroes praesentium maiores, sint eos vero sapiente voluptas debitis dicta dolore.</p>
                    <div class="bottom">
                        <a href="#">Read more</a>
                        <i>- Someone famous</i>
                    </div> -->
                </section>
            </div>
        @endforeach

        <div class="row row-2">
            <section id="last"></section>
        </div>
    </div>
