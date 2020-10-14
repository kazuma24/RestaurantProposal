<!-- 現在地データ保持HTML -->
<form action="/locationinfomation" id="locationinfomationform" method="post" style="display: none;">
    @csrf
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
</form>
