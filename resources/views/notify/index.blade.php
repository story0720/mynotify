@extends('template.index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mt-3 mr-n1 d-flex">
                    <div class="mr-auto w-100">
                        <a href="/kaohsiung/calendar?from=2023-04-22&amp;to=2023-04-28"
                            class="btn btn-outline-primary mr-1 active">全部</a>
                        <a href="/kaohsiung/calendar/expo?from=2023-04-22&amp;to=2023-04-28"
                            class="btn btn-outline-primary mr-1">展覽</a>
                        <a href="/kaohsiung/calendar/music?from=2023-04-22&amp;to=2023-04-28"
                            class="btn btn-outline-primary mr-1">音樂</a>
                        <a href="/kaohsiung/calendar/drama?from=2023-04-22&amp;to=2023-04-28"
                            class="btn btn-outline-primary mr-1">戲劇</a>
                        <div class="ml-auto">
                            <a href="/kaohsiung/events" class="btn btn-link mr-1">
                                <i class="fas fa-exchange-alt"></i>
                                列表
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary text-nowrap" data-coreui-toggle="modal"
                            data-coreui-target="#add-modal">
                            新增
                        </button>
                    </div>
                </div>

                <div class="">
                    <h1 class="h3 mt-4 mb-0 font-weight-bold">
                        <a href="/kaohsiung/calendar" class="text-black">高雄行事曆</a>
                        <i class="fas fa-angle-right ml-1 text-muted"></i>
                        <a href="/kaohsiung/calendar" class="text-black">
                            最新活動
                        </a>
                    </h1>
                    <div class="mt-2">
                        <i class="far fa-calendar-alt"></i>&nbsp;
                        2023年4月22日 – 4月28日
                    </div>
                </div>
                <div class="pb-4">
                    <h6 class="mb-0 mt-2" style="line-height: 1.5;">注意：<span
                            class="text-danger">出發前請去官網再次確認！</span>本站內容由程式自動抓取，沒有算到<span
                            class="text-danger">疫情影響</span>、<span class="text-danger">例行休館日</span>、<span
                            class="text-danger">國定假日</span>、<span class="text-danger">移師外地舉辦</span>等等特殊情況。</h6>
                    <div class="mt-3">
                        <a class="btn btn-default" href="/kaohsiung/calendar">
                            今天
                        </a>
                        <div class="btn-group ml-2">
                            <a class="btn btn-link" href="/kaohsiung/calendar?from=2023-04-15&amp;to=2023-04-21">
                                前一週
                            </a>
                            <a class="btn btn-link" href="/kaohsiung/calendar?from=2023-04-29&amp;to=2023-05-05">
                                後一週
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $todayCarbon = Carbon\Carbon::parse($today);
        $daysOfWeek = ['週日', '週一', '週二', '週三', '週四', '週五', '週六'];
    @endphp
    @for ($i = 0; $i <= 30; $i++)
        @php
            $currentDate = $todayCarbon->copy()->addDays($i);
            $filteredNotify = $notify
                ->filter(function ($item) use ($currentDate) {
                    return $item->starttime->lte($currentDate) && $item->endtime->gte($currentDate);
                })
                ->take(3);
        @endphp
        <hr>
        <h5 class=" px-5 py-3 d-flex justify-content-between">
            {{-- {{dd($currentDate->format('Y-m-d'))}} --}}
            <span> {{ $currentDate->format('Y-m-d') }} ({{ $daysOfWeek[$currentDate->dayOfWeek] }})</span>
            <a href="/kaohsiung/calendar?date={{ $currentDate->format('Y-m-d') }}" class="pr-2">查看全部</a>
        </h5>
        <div class="px-5 container text-center">
            <div class="row">
                @foreach ($filteredNotify as $item)
                    <div class="col-4">
                        <div class="card"><img
                                data-src="http://yii.tw/event-image/600x600/305394c8527e5a386ef5ebaf4c5b065a.jpg"
                                class="card-img-top"
                                src="http://yii.tw/event-image/600x600/305394c8527e5a386ef5ebaf4c5b065a.jpg"
                                data-was-processed="true">
                            <div class="card-body">
                                <h6><a href="/events/11833" class="text-break">科工想見你-收錄音機藏品展</a></h6>
                                <a href="/kaohsiung/calendar?place=nstm">
                                    <div class="place text-break">國立科學工藝博物館</div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endfor



    <!-- Modal -->
    <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-event-modal-label">新增活動</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="event-name" class="col-form-label">名稱：</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="event-content" class="col-form-label">內容：</label>
                            <textarea name="content" class="form-control" id="content"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="start-time" class="col-form-label">開始時間：</label>
                            <input type="datetime-local" name="starttime" class="form-control" id="starttime"
                                value="{{ $nowday }}" required>
                        </div>
                        <div class="form-group">
                            <label for="end-time" class="col-form-label">結束時間：</label>
                            <input type="datetime-local" name="endtime" class="form-control" id="endtime"
                                value="{{ $nowday }}" required>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" name="status"class="form-check-input" id="status" checked>
                            <label class="form-check-label" for="event-enabled">是否有效</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">取消</button>
                        <button type="submit" id="btn-submit" name="btn-add" class="btn btn-primary">新增</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $("#btn-submit").click(function(e) {
                // e.preventDefault(); // 防止表單正常提交
                // let title = $("#title").val();
                // let content = $("#content").val();
                // let starttime = $("#starttime").val();
                // let endtime = $("#endtime").val();
                // let status = $("#status").val();
                // $.ajax({
                //     type: 'POST',
                //     url: "{{ route('notify.store') }}",
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     data: $('#form').serialize(), // 將表單數據序列化
                //     success: function(data) {
                //         // 根據後端回應顯示 SweetAlert
                //         Swal.fire({
                //             title: data.status === 'success' ? '成功！' : '錯誤！',
                //             text: data.message,
                //             icon: data.status,
                //             confirmButtonText: '確定',
                //         }).then(() => {
                //             if (data.status === 'success') {

                //                 $("#title").val('');
                //                 $("#content").val('');
                //             }
                //         });
                //     },
                //     error: function(error) {
                //         // 顯示錯誤 SweetAlert
                //         Swal.fire({
                //             title: '儲存錯誤！',
                //             text: error.message,
                //             icon: error.icon,
                //             confirmButtonText: '確定',
                //         });
                //     }
                // });
            });
        });
    </script>
@endsection
