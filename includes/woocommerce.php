<?php
/* Remove product meta */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);


/**
 * @snippet       Move product tabs beside the product image - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);


function action_woocommerce_before_add_to_cart_form()
{
    if (has_term('tamper-evident-containers', 'product_cat', get_the_ID())) {
?>
        <div class="product-features">
            <p>
                <strong>Product Features:</strong>
            </p>
            <div class="product-features-box">
                <div class="product-feature">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Group_406" data-capacity="Group 406" width="88" height="88" viewBox="0 0 88 88">
                        <defs>
                            <clipPath id="clip-path">
                                <rect id="Rectangle_125" data-capacity="Rectangle 125" width="58.3" height="52.357" fill="#fff" />
                            </clipPath>
                        </defs>
                        <g id="Group_400" data-capacity="Group 400" transform="translate(0 0)">
                            <g id="Group_313" data-capacity="Group 313">
                                <g id="Group_210" data-capacity="Group 210">
                                    <rect id="Rectangle_5" data-capacity="Rectangle 5" width="88" height="88" rx="10" fill="#1c4350" />
                                </g>
                            </g>
                            <g id="Group_268" data-capacity="Group 268" transform="translate(14.686 20.451)">
                                <g id="Group_267" data-capacity="Group 267" clip-path="url(#clip-path)">
                                    <path id="Path_122" data-capacity="Path 122" d="M17.477,179.464l-2.632,5.243c.934.05,1.758.1,2.584.137,2.355.1,4.71.191,7.064.3,1.179.055,1.472.379,1.473,1.545q0,5.034,0,10.067c0,1.141-.309,1.453-1.455,1.454-4.494,0-8.989-.008-13.483.011a1.563,1.563,0,0,1-1.44-.763q-4.6-6.866-9.244-13.708A1.506,1.506,0,0,1,.3,181.89c1.931-3.125,3.826-6.273,5.733-9.412.113-.186.22-.376.37-.634-.419-.293-.817-.58-1.223-.853a1.059,1.059,0,0,1-.555-1.212c.149-.557.589-.7,1.109-.72q4.971-.169,9.941-.343c.8-.027,1.056.149,1.342.912q1.76,4.71,3.515,9.421a1.017,1.017,0,0,1-.167,1.26,1.035,1.035,0,0,1-1.327.036c-.5-.286-1-.565-1.565-.88M8.627,192.4c.137-.248.244-.431.341-.62q3.453-6.7,6.909-13.4a2.557,2.557,0,0,1,.686-1.018,3.165,3.165,0,0,1,1.225-.182c0,.032.011-.01,0-.044-.75-2.039-1.493-4.081-2.273-6.109a.731.731,0,0,0-.579-.322c-1.5.036-2.992.112-4.487.179-.572.026-1.144.062-1.8.1a1.452,1.452,0,0,1-.265,1.595c-2.007,3.24-4,6.489-6.013,9.724a.738.738,0,0,0,.021.949c1.968,2.885,3.914,5.785,5.868,8.68.1.143.21.275.363.474m15.279-5.238a2.965,2.965,0,0,0-.311-.05c-3.109-.147-6.218-.284-9.326-.448-.374-.02-.479.189-.609.438-.988,1.891-1.9,3.83-3,5.653a2.25,2.25,0,0,0,.145,3.066,1.059,1.059,0,0,0,.876.452c3.871-.013,7.742-.007,11.614-.009.194,0,.387-.019.609-.03Z" transform="translate(0 -148.485)" fill="#fff" />
                                    <path id="Path_123" data-capacity="Path 123" d="M116.448,16.516l-2.887-5.139c-1.026,1.385-2,2.7-2.969,4.008q-1.425,1.927-2.847,3.857c-.594.8-1.06.879-1.862.285q-4.334-3.209-8.66-6.428a1.161,1.161,0,0,1-.251-1.957q4.355-5.225,8.709-10.451A1.762,1.762,0,0,1,107.174,0q7.732.028,15.463,0a1.4,1.4,0,0,1,1.473.941c1.515,3.411,3.063,6.807,4.6,10.207.073.16.161.314.261.506.546-.2,1.066-.395,1.584-.59a.918.918,0,0,1,1.139.247.934.934,0,0,1,.046,1.169q-2.707,4.348-5.424,8.69a1.136,1.136,0,0,1-1.347.515q-4.911-1.212-9.828-2.4c-.5-.121-.911-.3-.987-.885s.3-.861.752-1.088c.5-.248.988-.512,1.542-.8m-5.741-14.65c.109.239.172.4.255.552q3.691,6.718,7.38,13.437A2.381,2.381,0,0,1,118.775,17c-.026.363-.383.7-.612,1.082,2.043.5,4.136,1,6.219,1.532a.583.583,0,0,0,.763-.325c1.024-1.667,2.068-3.322,3.1-4.982.07-.113.122-.238.182-.358l-.179.09a6.26,6.26,0,0,1-.94-1.182q-2.391-5.193-4.7-10.422a.814.814,0,0,0-.883-.582c-3.456.023-6.911.012-10.367.012ZM98.932,11.874,106.5,17.5c.113-.119.174-.172.221-.235,1.878-2.459,3.748-4.923,5.639-7.372a.629.629,0,0,0,.01-.8Q110.6,5.8,108.836,2.5a1.175,1.175,0,0,0-1.906-.2q-1.7,2.014-3.387,4.037c-1.522,1.823-3.04,3.649-4.61,5.534" transform="translate(-84.97 -0.001)" fill="#fff" />
                                    <path id="Path_124" data-capacity="Path 124" d="M264.888,182.819l5.851-.5c-.107-.219-.183-.4-.275-.563q-2.2-3.986-4.4-7.971c-.475-.861-.348-1.352.5-1.823q4.789-2.666,9.584-5.323c.75-.416,1.183-.3,1.555.462,2.04,4.179,4.08,8.358,6.08,12.557a1.674,1.674,0,0,1,0,1.245c-2.157,4.85-4.357,9.682-6.538,14.521a1.241,1.241,0,0,1-1.317.715q-5.514-.012-11.028,0h-.752c-.033.578-.078,1.092-.088,1.607a1,1,0,0,1-.7,1.01.938.938,0,0,1-1.128-.46c-.408-.567-.791-1.152-1.182-1.732q-2.192-3.255-4.382-6.512a1.176,1.176,0,0,1,.028-1.679q3.075-3.947,6.16-7.887c.456-.582.99-.778,1.428-.438a1.5,1.5,0,0,1,.494.877,16.941,16.941,0,0,1,.105,1.9m-2.554,12.076a1.569,1.569,0,0,1,1.528-.665c3.795.01,7.59,0,11.384.014a.74.74,0,0,0,.8-.511c1.437-3.226,2.9-6.439,4.358-9.657.063-.139.1-.288.171-.49-.257.012-.453.016-.649.032q-7.64.616-15.28,1.226a2.087,2.087,0,0,1-1.152-.13c-.305-.181-.457-.62-.692-.97l-4.278,5.481,3.8,5.671m5.7-21.568c.118.234.185.377.261.516,1.4,2.554,2.824,5.1,4.2,7.67a.933.933,0,0,0,1.064.581c2.386-.209,4.776-.38,7.165-.559a1.163,1.163,0,0,0,1.033-1.765q-2.6-5.294-5.2-10.585c-.075-.152-.175-.292-.287-.475l-8.229,4.618" transform="translate(-225.603 -146.452)" fill="#fff" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="product-feature">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="89" height="88" viewBox="0 0 89 88">
                        <defs>
                            <clipPath id="clip-path">
                                <rect id="Rectangle_124" data-capacity="Rectangle 124" width="59.296" height="39.183" fill="#fff" />
                            </clipPath>
                        </defs>
                        <g id="Group_405" data-capacity="Group 405" transform="translate(0.455)">
                            <g id="Group_401" data-capacity="Group 401" transform="translate(0)">
                                <g id="Group_313" data-capacity="Group 313">
                                    <g id="Group_210" data-capacity="Group 210">
                                        <rect id="Rectangle_5" data-capacity="Rectangle 5" width="89" height="88" rx="10" transform="translate(-0.456)" fill="#1c4350" />
                                    </g>
                                </g>
                                <g id="Group_266" data-capacity="Group 266" transform="translate(14.865 24.477)">
                                    <g id="Group_265" data-capacity="Group 265" clip-path="url(#clip-path)">
                                        <path id="Path_116" data-capacity="Path 116" d="M14.921,36.049c-.027.236-.054.448-.074.661a2.5,2.5,0,0,1-2.574,2.447c-.874.032-1.751.019-2.626.006a2.519,2.519,0,0,1-2.761-2.676c-.007-.134-.031-.267-.06-.511-.63,0-1.252.006-1.873,0A4.742,4.742,0,0,1,.007,31Q-.008,17.99.007,4.978A4.722,4.722,0,0,1,4.955.009q24.705-.016,49.411,0a4.656,4.656,0,0,1,4.926,4.953q.008,13.012,0,26.024a4.677,4.677,0,0,1-4.972,4.99c-.57,0-1.14,0-1.652,0-.089.123-.148.166-.149.21-.043,2.193-1.347,3.124-3.343,2.983-.436-.031-.875,0-1.313,0-2.464,0-3.194-.649-3.435-3.116Zm7.461-1.862c5.828,0,11.656-.015,17.483.018.8,0,.994-.242.992-1.016Q40.82,18,40.861,2.812c0-.859-.251-1.034-1.06-1.032Q22.564,1.819,5.327,1.8c-2.422,0-3.508,1.086-3.509,3.5q0,12.684,0,25.368c0,2.428,1.076,3.515,3.49,3.516q8.536,0,17.073,0m20.327-.038c.327.014.595.036.863.037q5.252,0,10.5,0c2.346,0,3.427-1.07,3.428-3.4q.006-12.8,0-25.607C57.5,2.9,56.4,1.8,54.135,1.8q-5.293-.007-10.586,0c-.266,0-.532.025-.841.041ZM12.955,36.07h-4.2c-.118,1.031.069,1.278.973,1.293q1.148.019,2.3,0c.881-.016,1.1-.313.931-1.293m33.422-.049c-.147.6-.164,1.2.447,1.269a17.647,17.647,0,0,0,3.261,0c.213-.017.419-.537.553-.857.028-.067-.275-.392-.43-.4-1.277-.033-2.556-.019-3.831-.019" transform="translate(0 0)" fill="#fff" />
                                        <path id="Path_117" data-capacity="Path 117" d="M43.044,57.28q-7.84,0-15.679,0c-1.344,0-1.51-.169-1.51-1.516q0-11.249,0-22.5c0-1.317.2-1.51,1.528-1.51H58.659c1.379,0,1.543.167,1.543,1.571q0,11.208,0,22.415c0,1.409-.132,1.538-1.56,1.539h-15.6M27.712,55.454H58.335V33.6H27.712Z" transform="translate(-21.609 -26.541)" fill="#fff" />
                                        <path id="Path_118" data-capacity="Path 118" d="M275.817,41.794c-1.557,0-3.114.007-4.671,0-.94-.006-1.234-.294-1.242-1.215q-.016-1.967,0-3.934c.008-.9.267-1.162,1.189-1.164q4.753-.012,9.506,0c.952,0,1.177.215,1.19,1.151.019,1.284.015,2.568,0,3.852-.01,1.074-.246,1.307-1.305,1.312-1.557.007-3.114,0-4.671,0m4.221-1.864c0-.687-.033-1.335.01-1.978.039-.592-.208-.743-.762-.737-2.129.024-4.258.01-6.386.01h-1.124v2.7Z" transform="translate(-225.584 -29.648)" fill="#fff" />
                                        <path id="Path_119" data-capacity="Path 119" d="M290,153.127a3.872,3.872,0,0,1-3.926,3.883,3.96,3.96,0,0,1-3.94-3.911,4.017,4.017,0,0,1,4.009-3.95A3.926,3.926,0,0,1,290,153.127m-3.905-2.157a2.127,2.127,0,0,0-2.136,2.138,2.155,2.155,0,0,0,2.084,2.121,2.118,2.118,0,0,0,2.161-2.109,2.094,2.094,0,0,0-2.109-2.15" transform="translate(-235.816 -124.662)" fill="#fff" />
                                        <path id="Path_120" data-capacity="Path 120" d="M292.2,98.487c.6,0,1.2-.014,1.795,0a.892.892,0,1,1,.03,1.783,34.032,34.032,0,0,1-3.749-.031,1.3,1.3,0,0,1-.866-.858c-.1-.545.339-.88.914-.9.625-.017,1.251,0,1.876,0" transform="translate(-241.878 -82.313)" fill="#fff" />
                                        <path id="Path_121" data-capacity="Path 121" d="M292.05,121.733c-.6,0-1.2.014-1.805-.005a.862.862,0,0,1-.944-.915.844.844,0,0,1,.912-.863q1.846-.03,3.692,0a.831.831,0,0,1,.927.914c-.015.62-.418.854-.977.867-.6.014-1.2,0-1.805,0" transform="translate(-241.803 -100.243)" fill="#fff" />
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="product-feature">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="89" height="88" viewBox="0 0 89 88">
                        <defs>
                            <clipPath id="clip-path">
                                <rect id="Rectangle_123" data-capacity="Rectangle 123" width="56.297" height="60.39" fill="#fff" />
                            </clipPath>
                        </defs>
                        <g id="Group_404" data-capacity="Group 404" transform="translate(0.222)">
                            <g id="Group_313" data-capacity="Group 313" transform="translate(0)">
                                <g id="Group_210" data-capacity="Group 210" transform="translate(0)">
                                    <rect id="Rectangle_5" data-capacity="Rectangle 5" width="89" height="88" rx="10" transform="translate(-0.222)" fill="#1c4350" />
                                </g>
                            </g>
                            <g id="Group_264" data-capacity="Group 264" transform="translate(15.734 13.707)">
                                <g id="Group_263" data-capacity="Group 263" clip-path="url(#clip-path)">
                                    <path id="Path_112" data-capacity="Path 112" d="M32.188,27.337v1.04c0,7.387-.025,14.774.013,22.161.014,2.693-.994,4.619-3.6,5.589a.988.988,0,0,0-.442.749c-.118,2.467-1.206,3.521-3.665,3.487a3.07,3.07,0,0,1-3.371-3.284c-.011-.219-.044-.438-.071-.7H11.029c0,.391.015.748,0,1.1a2.9,2.9,0,0,1-2.4,2.782A4.2,4.2,0,0,1,5.22,59.73a3.384,3.384,0,0,1-1.241-2.748,1.179,1.179,0,0,0-.5-.888A5.165,5.165,0,0,1,0,50.772q.033-18.9.01-37.81c0-1.043-.02-2.087.017-3.129a4.955,4.955,0,0,1,4.5-4.784A12.6,12.6,0,0,1,5.794,5c6.88,0,13.759-.014,20.639.013a10.058,10.058,0,0,1,2.489.361.819.819,0,0,0,1-.272A14.874,14.874,0,0,1,38.438.266,15.062,15.062,0,0,1,56.291,15.312a14.4,14.4,0,0,1-7.9,13c-5.16,2.785-10.344,2.464-15.355-.58-.216-.131-.429-.267-.645-.4-.019-.012-.052,0-.208,0M2.075,24.113c-.032.3-.065.466-.065.632q0,13.19.007,26.38A2.969,2.969,0,0,0,5.285,54.3q10.7,0,21.391,0c2.342,0,3.483-1.127,3.484-3.465q.005-12.345,0-24.689a1.824,1.824,0,0,0-1.984-2.028H2.075m.017-2.073H27.813a15.321,15.321,0,0,1,.507-14.866c-.7-.062-1.248-.151-1.793-.152q-10.439-.014-20.877,0a8.4,8.4,0,0,0-.844.03,2.9,2.9,0,0,0-2.77,2.88c-.046,3.916-.021,7.832-.02,11.748a1.982,1.982,0,0,0,.076.365M41.281,28.1a13.052,13.052,0,1,0-13.093-13.03A12.972,12.972,0,0,0,41.281,28.1M8.918,56.339c-.684,0-1.331-.042-1.97.018-.323.03-.86.2-.9.389-.114.575-.076,1.3.637,1.468,1.4.338,2.7.194,2.23-1.874m14.061.049c.222.659.273,1.533.612,1.665a3.112,3.112,0,0,0,2.129-.022c.326-.133.348-1.014.532-1.643Z" transform="translate(0 0)" fill="#fff" />
                                    <path id="Path_113" data-capacity="Path 113" d="M25.685,158.772q0,1.434,0,2.867c0,.614-.25,1.063-.9,1.1a.941.941,0,0,1-1.06-1.044c-.027-1.967-.022-3.935,0-5.9a.925.925,0,0,1,1-1.018c.708.011.964.471.963,1.125,0,.956,0,1.912,0,2.867" transform="translate(-19.694 -128.593)" fill="#fff" />
                                    <path id="Path_114" data-capacity="Path 114" d="M25.673,75.309q0,1.478,0,2.956c0,.617-.259,1.066-.907,1.1a.945.945,0,0,1-1.056-1.051c-.027-1.942-.024-3.884-.008-5.826.005-.641.331-1.123,1.012-1.112s.966.482.962,1.142c-.006.929,0,1.858,0,2.787" transform="translate(-19.681 -59.303)" fill="#fff" />
                                    <path id="Path_115" data-capacity="Path 115" d="M190.733,37.746c0,1.147-.029,2.294.024,3.439a1.177,1.177,0,0,0,.506.7c.609.455,1.263.849,1.889,1.282a.99.99,0,0,1,.359,1.462c-.381.593-.93.544-1.477.2-.376-.24-.751-.482-1.192-.766-.265.791.107,2.029-1.2,1.976-1.2-.049-.805-1.2-1.043-1.991-.478.3-.892.575-1.317.83a1,1,0,1,1-1.1-1.661c.644-.456,1.346-.838,1.95-1.339a1.622,1.622,0,0,0,.544-1.018c.072-1.032.025-2.073.025-3.36-.485.456-.821.759-1.142,1.076-.683.673-1.358,1.354-2.037,2.031-.483.481-1.036.66-1.554.125s-.33-1.085.163-1.555q1.49-1.42,2.988-2.832l-.151-.293c-1.191,0-2.383-.021-3.573.022-.185.007-.395.284-.533.478-.457.643-.883,1.308-1.329,1.959a1,1,0,1,1-1.67-1.1c.255-.4.514-.792.834-1.285-.874-.18-2.076.115-2.01-1.171.058-1.114,1.093-.9,2-.98-.291-.473-.525-.866-.772-1.252a.958.958,0,0,1,.214-1.475.981.981,0,0,1,1.456.369c.4.579.824,1.148,1.167,1.761a1.19,1.19,0,0,0,1.243.643c.976-.038,1.954-.01,3.2-.01-.547-.569-.919-.964-1.3-1.35-.613-.623-1.244-1.229-1.844-1.865a.991.991,0,1,1,1.409-1.391c.833.8,1.64,1.629,2.461,2.443.192.19.4.366.759.7,0-1.4.021-2.6-.021-3.794-.007-.192-.269-.412-.462-.551-.595-.427-1.214-.821-1.823-1.228-.561-.375-.868-.876-.464-1.5s.975-.572,1.55-.192c.348.23.7.452,1.109.713.286-.782-.162-2.055,1.2-1.972,1.134.07.868,1.113,1.009,1.984.456-.287.841-.535,1.231-.775a1,1,0,1,1,1.123,1.648c-.621.439-1.294.811-1.879,1.292a1.491,1.491,0,0,0-.509.946c-.064,1.057-.024,2.121-.024,3.182l.292.193c.73-.8,1.457-1.606,2.19-2.4.21-.228.432-.445.66-.656a.982.982,0,0,1,1.5-.059c.493.5.343,1.028-.111,1.489-.752.763-1.513,1.517-2.268,2.278-.214.216-.42.44-.8.845,1.437,0,2.655.017,3.871-.02.163,0,.347-.262.47-.438.421-.6.818-1.216,1.227-1.824.378-.561.884-.85,1.5-.451s.576.966.183,1.54c-.234.342-.445.7-.716,1.131.846.182,2.006-.109,1.99,1.116-.015,1.2-1.112.927-1.989,1.062.3.476.558.893.815,1.315a1,1,0,1,1-1.674,1.088c-.416-.6-.849-1.2-1.215-1.832a1.207,1.207,0,0,0-1.244-.647c-.981.04-1.965.011-3.184.011.335.383.529.628.747.849q1.128,1.145,2.27,2.275c.481.477.662,1,.185,1.566-.411.488-1.013.427-1.618-.175-.956-.953-1.886-1.932-2.827-2.9l-.247.1" transform="translate(-148.454 -19.95)" fill="#fff" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="product-feature">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="88" height="88" viewBox="0 0 88 88">
                        <defs>
                            <clipPath id="clip-path">
                                <rect id="Rectangle_164" data-capacity="Rectangle 164" width="43.601" height="54.183" fill="#fff" />
                            </clipPath>
                        </defs>
                        <g id="Group_403" data-capacity="Group 403" transform="translate(-0.323)">
                            <g id="Group_402" data-capacity="Group 402" transform="translate(0)">
                                <g id="Group_210" data-capacity="Group 210">
                                    <rect id="Rectangle_5" data-capacity="Rectangle 5" width="88" height="88" rx="10" transform="translate(0.323)" fill="#1c4350" />
                                </g>
                            </g>
                            <g id="Group_389" data-capacity="Group 389" transform="translate(24.725 19.581)">
                                <g id="Group_388" data-capacity="Group 388" transform="translate(-2.403 -2.581)" clip-path="url(#clip-path)">
                                    <path id="Path_178" data-capacity="Path 178" d="M42.1,17.72c-.084-1.476-.039-2.959-.04-4.439,0-.42,0-.84,0-1.428-2.8,0-5.466-.01-8.132.018a.967.967,0,0,0-.631.415,12.63,12.63,0,0,0-.728,1.283,5.181,5.181,0,0,1-4.806,2.879q-5.963.039-11.927,0a4.876,4.876,0,0,1-4.763-2.9,2.609,2.609,0,0,0-2.986-1.729c-2.13.132-4.274.034-6.475.034V46.242H42.056V45.067q0-11.262,0-22.525ZM7.913,54.144c-1.794.011-3.59.044-5.383-.013A2.633,2.633,0,0,1,.02,51.612c-.025-.351-.019-.7-.019-1.057Q0,27.079,0,3.6C0,.858.853,0,3.577,0H40.309c2.3,0,3.285.964,3.288,3.255q.011,6.979,0,13.959l-.02.52.02,4.634q0,14.17,0,28.341c0,2.527-.913,3.439-3.424,3.439H12.732c-.282,0-1.175.034-1.175.034Zm3.922-1.534c.316,0,.691-.045,1.042-.045H39.9c1.965,0,2.158-.2,2.159-2.189,0-.773,0-1.547,0-2.406H1.551c0,1.177-.04,2.3.013,3.417.041.878.658,1.174,1.458,1.176,1.583,0,3.168-.027,4.749.03ZM1.546,10.2h40.51c0-2.211,0-4.323,0-6.435,0-1.98-.2-2.18-2.164-2.181H3.7c-.281,0-.563,0-.844.012A1.209,1.209,0,0,0,1.549,2.927c-.01,2.394,0,4.788,0,7.276m30.029,1.688H12.1a3.57,3.57,0,0,0,3.631,2.921q5.857.015,11.713,0c2.234,0,3.164-.639,4.128-2.924" transform="translate(0 0)" fill="#fff" />
                                    <path id="Path_179" data-capacity="Path 179" d="M27.412,15.994c2.178,0,4.356-.008,6.535,0,1.22.006,1.637.424,1.667,1.642.015.6.019,1.2,0,1.795-.04,1.1-.436,1.542-1.556,1.548q-6.745.034-13.49,0c-1.077-.007-1.481-.5-1.5-1.6q-.019-.9,0-1.8C19.086,16.44,19.512,16,20.667,16c2.248-.014,4.5,0,6.745,0m6.608,1.69H20.661V19.29H34.02Z" transform="translate(-15.021 -12.608)" fill="#fff" />
                                    <path id="Path_180" data-capacity="Path 180" d="M162.814,19.06A3.21,3.21,0,1,1,166,15.826a3.169,3.169,0,0,1-3.186,3.234m-.006-1.58a1.651,1.651,0,0,0,1.613-1.631,1.693,1.693,0,0,0-1.6-1.649,1.676,1.676,0,0,0-1.668,1.686,1.693,1.693,0,0,0,1.658,1.593" transform="translate(-125.83 -9.966)" fill="#fff" />
                                    <path id="Path_181" data-capacity="Path 181" d="M123.055,19.468a5.477,5.477,0,0,1-.033,1.461,1.314,1.314,0,0,1-.766.789c-.175.051-.708-.414-.728-.673a20.812,20.812,0,0,1,.009-3.244.987.987,0,0,1,.769-.6,1.072,1.072,0,0,1,.711.7,6.966,6.966,0,0,1,.032,1.567h0" transform="translate(-95.774 -13.559)" fill="#fff" />
                                    <path id="Path_182" data-capacity="Path 182" d="M141.028,19.506a5.278,5.278,0,0,1-.034,1.459,1.274,1.274,0,0,1-.792.75c-.176.042-.672-.439-.694-.711a19.77,19.77,0,0,1,0-3.139c.02-.256.522-.709.708-.665a1.233,1.233,0,0,1,.779.743,6.264,6.264,0,0,1,.034,1.565" transform="translate(-109.947 -13.559)" fill="#fff" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>

    <?php
    }
}

add_action('woocommerce_before_add_to_cart_form', 'action_woocommerce_before_add_to_cart_form');


function action_woocommerce_after_add_to_cart_button()
{
    ?>
    <a href="#" class="quick-buy">Quick Buy Option</a>
    <?php
}

add_action('woocommerce_after_add_to_cart_button', 'action_woocommerce_after_add_to_cart_button');


function gb_change_cart_string($translated_text, $text, $domain)
{

    $translated_text = str_replace('cart', 'basket', $translated_text);

    $translated_text = str_replace('Cart', 'Basket', $translated_text);

    return $translated_text;
}

add_filter('gettext', 'gb_change_cart_string', 99999, 3);

/**
 * @snippet       Add a Custom Sorting Option @ WooCommerce Shop
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 4.0
 * @community     https://businessbloomer.com/club/
 */

// 1. Create new product sorting rule

add_filter('woocommerce_get_catalog_ordering_args', 'quantitiessort_by_capacity_woocommerce_shop');

function quantitiessort_by_capacity_woocommerce_shop($args)
{
    $orderby_value = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));
    if ('capacity-desc' == $orderby_value || 'capacity-asc' == $orderby_value) {
        $args['meta_key'] = 'capacity';
        $args['orderby'] = 'meta_value_num';
    }
    if ('capacity-desc' == $orderby_value) {
        $args['order'] = 'DESC';
    }
    if ('capacity-asc' == $orderby_value) {
        $args['order'] = 'ASC';
    }
    return $args;
}

// 2. Add new product sorting option to Sorting dropdown

add_filter('woocommerce_catalog_orderby', 'quantitiesload_custom_woocommerce_catalog_sorting');

function quantitiesload_custom_woocommerce_catalog_sorting($options)
{
    $options['capacity-desc'] = 'Capacity: large first';
    $options['capacity-asc'] = 'Capacity: small first';
    return $options;
}
/*
function _products()
{
    ob_start();
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 50,
        'paged' => $_GET['page_val'],
    );
    $query = new WP_Query($args);
    while ($query->have_posts()) {
        $query->the_post();
        $product = wc_get_product(get_the_ID());
        $pa_capacity = $product->get_attribute('pa_capacity');
        echo '<li>';
        echo get_the_title() . '----' . get_post_meta(get_the_ID(), 'capacity_value', true);
        update_post_meta(get_the_ID(), 'capacity_value', $pa_capacity);
        echo '</li>';
    ?>

    <?php
    }
    return ob_get_clean();
}

add_shortcode('_products', '_products');*/
function variation_upload_file_by_url($image_url)
{

    // it allows us to use download_url() and wp_handle_sideload() functions
    require_once(ABSPATH . 'wp-admin/includes/file.php');

    // download to temp dir
    $temp_file = download_url($image_url);

    if (is_wp_error($temp_file)) {
        return false;
    }

    // move the temp file into the uploads directory
    $file = array(
        'name'     => basename($image_url),
        'type'     => mime_content_type($temp_file),
        'tmp_name' => $temp_file,
        'size'     => filesize($temp_file),
    );
    $sideload = wp_handle_sideload(
        $file,
        array(
            'test_form'   => false // no needs to check 'action' parameter
        )
    );

    if (!empty($sideload['error'])) {
        // you may return error message if you want
        return false;
    }

    // it is time to add our uploaded image into WordPress media library
    $attachment_id = wp_insert_attachment(
        array(
            'guid'           => $sideload['url'],
            'post_mime_type' => $sideload['type'],
            'post_title'     => basename($sideload['file']),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ),
        $sideload['file']
    );

    if (is_wp_error($attachment_id) || !$attachment_id) {
        return false;
    }

    // update medatata, regenerate image sizes
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    wp_update_attachment_metadata(
        $attachment_id,
        wp_generate_attachment_metadata($attachment_id, $sideload['file'])
    );

    return $attachment_id;
}
function _url_is_valid($url = null)
{
    $code = '';
    if (is_null($url)) {
        return false;
    } else {
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($code == '200') {
            return true;
        } else {
            return false;
        }
        curl_close($handle);
    }
}

function _products()
{
    ob_start();
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'paged' => $_GET['page_val'],
        'post_status' => 'publish'

    );
    $query = new WP_Query($args);
    echo "<pre>";
    var_dump(carbon_get_post_meta(8017, 'tech_sheets'));
    //carbon_set_post_meta(8786, 'tech_sheets[0]/tech_sheet_heading', 'Hello World!');
    //carbon_set_post_meta(8786, 'tech_sheets[0]/tech_sheet_file', 10199);
    variation_upload_file_by_url('https://systempak.net/wp-content/uploads/2016/11/TDS-2108-2000ML.pdf');
    echo "</pre>";

    echo '<table>';
    while ($query->have_posts()) {
        $query->the_post();

        $product = wc_get_product(get_the_ID());

        if ($product->get_type() == "variable") {
            foreach ($product->get_variation_attributes() as $variations) {
                echo '<tr>';
                echo '<td>';
                echo '<a href="' . get_the_permalink() . '">';
                echo get_the_title();
                echo '</a>';
                echo '</td>';
                echo '<td>';
                echo '<ol>';
                foreach ($variations as $variation) {
                    echo '<li>';
                    echo $product->get_title() . " - " . $variation;
                    echo '</li>';
                }
                echo '</ol>';
                echo '</td>';

                echo '</tr>';
            }
        }

        $tech_sheets = carbon_get_post_meta(get_the_ID(), 'tech_sheets');
        /*
        echo '<tr>';
        echo '<td><a href="' . get_permalink() . '">' . get_the_title() . '</a></td>';
        echo "<td>";
        echo var_dump($tech_sheets);
        //$pdf_id =  variation_upload_file_by_url($pdf_url);
        //carbon_set_post_meta($post_id, 'tech_sheets[' . $key . ']/tech_sheet_file', $pdf_id);
        //update_post_meta($post_id, $title_id, '');
        //update_post_meta($post_id, $content_id, '');
        echo "</td>";
        echo '</tr>';
        /*
        if ($custom_tab_content1 && $custom_tab_title1 == 'Tech Sheet') {
            foreach (extract_url($custom_tab_content1) as $key => $pdf) {
                $pdf_url = str_replace("spnew.theprogressteam.com", "systempak.net", $pdf);
                //if (_url_is_valid($pdf_url) == false) {
                echo _file_upload($pdf_url, get_the_title(), get_the_ID(), $key,  'custom_tab_title1', 'custom_tab_content1');
                //}
            }
        }
        if ($custom_tab_content2 && $custom_tab_title2 == 'Tech Sheet') {
            foreach (extract_url($custom_tab_content2) as $key => $pdf) {
                $pdf_url = str_replace("spnew.theprogressteam.com", "systempak.net", $pdf);
                //if (_url_is_valid($pdf_url) == false) {
                echo _file_upload($pdf_url, get_the_title(), get_the_ID(), $key,  'custom_tab_title2', 'custom_tab_content2');
                //}
            }
        }
        if ($custom_tab_content3 && $custom_tab_title3 == 'Tech Sheet') {
            foreach (extract_url($custom_tab_content3) as $key => $pdf) {
                $pdf_url = str_replace("spnew.theprogressteam.com", "systempak.net", $pdf);
                //if (_url_is_valid($pdf_url) == false) {
                echo _file_upload($pdf_url, get_the_title(), get_the_ID(), $key, 'custom_tab_title3', 'custom_tab_content3');
                //}
            }
        }
        //echo '<ol>';
        //echo '<li>' . $custom_tab_title1 . '</li>';
        //echo '<li>' . $custom_tab_title2 . '</li>';
        //echo '<li>' . $custom_tab_title3 . '</li>';
        //echo '</ol>';
*/
    ?>

    <?php
    }
    wp_reset_postdata();
    echo '</table>';

    return ob_get_clean();
}

function _file_upload($pdf_url, $title, $post_id, $key, $title_id, $content_id)
{
    ob_start();
    echo '<tr>';
    echo '<td><a href="' . get_permalink() . '">' . $title . '</a></td>';
    echo "<td>";
    echo $pdf_url;
    //$pdf_id =  variation_upload_file_by_url($pdf_url);
    //carbon_set_post_meta($post_id, 'tech_sheets[' . $key . ']/tech_sheet_file', $pdf_id);
    //update_post_meta($post_id, $title_id, '');
    //update_post_meta($post_id, $content_id, '');
    echo "</td>";
    echo '</tr>';
    return ob_get_clean();
}

function extract_url($string)
{
    preg_match_all('/\bhttp\S*?pdf\b/', $string, $match);
    return $match[0];
}

add_shortcode('_products', '_products');

// Display Fields
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
// Save Fields
function woocommerce_product_custom_fields()
{
    global $woocommerce, $post;
    echo '<div class="product_custom_field">';
    woocommerce_wp_text_input(
        array(
            'id' => 'capacity',
            'placeholder' => 'Capacity Sort By',
            'label' => __('Capacity Sort By', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            )
        )
    );

    woocommerce_wp_text_input(
        array(
            'id' => 'capacity_value',
            'placeholder' => 'Capacity value to appear on frontend',
            'label' => __('Capacity', 'woocommerce'),
            'type' => 'text',
        )
    );

    woocommerce_wp_text_input(
        array(
            'id' => 'quantity_per_box',
            'placeholder' => 'Quantity Per Box',
            'label' => __('Quantity Per Box', 'woocommerce'),
            'type' => 'text',
        )
    );

    echo '</div>';
}

add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');

function woocommerce_product_custom_fields_save($post_id)
{

    $capacity = $_POST['capacity'];
    update_post_meta($post_id, 'capacity', esc_attr($capacity));

    $capacity_value = $_POST['capacity_value'];
    update_post_meta($post_id, 'capacity_value', esc_attr($capacity_value));

    $quantity_per_box = $_POST['quantity_per_box'];
    update_post_meta($post_id, 'quantity_per_box', esc_attr($quantity_per_box));

    $custom_tab_title1 = $_POST['custom_tab_title1'];
    update_post_meta($post_id, 'custom_tab_title1', $custom_tab_title1);

    $custom_tab_content1 = $_POST['custom_tab_content1'];
    update_post_meta($post_id, 'custom_tab_content1', $custom_tab_content1);

    $custom_tab_title2 = $_POST['custom_tab_title2'];
    update_post_meta($post_id, 'custom_tab_title2', $custom_tab_title2);

    $custom_tab_content2 = $_POST['custom_tab_content2'];
    update_post_meta($post_id, 'custom_tab_content2', $custom_tab_content2);

    $custom_tab_title3 = $_POST['custom_tab_title3'];
    update_post_meta($post_id, 'custom_tab_title3', $custom_tab_title3);

    $custom_tab_content3 = $_POST['custom_tab_content3'];
    update_post_meta($post_id, 'custom_tab_content3', $custom_tab_content3);
}

add_action('add_meta_boxes', 'custom_tabs_meta_box');

function custom_tabs_meta_box()
{
    add_meta_box('custom_tabs_meta_box', 'Custom Tabs', 'action_custom_tabs_meta_box', 'product', 'advanced', 'high');
}

function action_custom_tabs_meta_box()
{
    global $post;
    $custom_tab_title1 = get_post_meta($post->ID, 'custom_tab_title1', true);
    $custom_tab_content1 = get_post_meta($post->ID, 'custom_tab_content1', true);
    $custom_tab_title2 = get_post_meta($post->ID, 'custom_tab_title2', true);
    $custom_tab_content2 = get_post_meta($post->ID, 'custom_tab_content2', true);
    $custom_tab_title3 = get_post_meta($post->ID, 'custom_tab_title3', true);
    $custom_tab_content3 = get_post_meta($post->ID, 'custom_tab_content3', true);
    ?>
    <style>
        .meta-box-fields .input-box>input[type="text"] {
            width: 100%;
        }

        .meta-box-fields .input-box {
            width: 90%;
            flex: 0 0 90%;
        }

        .meta-box-fields label {
            width: 10%;
            flex: 0 0 10%;
            margin-top: 7px;
        }

        .custom-tabs-holder .meta-box-fields {
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            display: flex;
            border-bottom: 1px solid lightgray;

        }
    </style>
    <div class="custom-tabs-wrapper">
        <div class="custom-tabs-holder">
            <div class="meta-box-fields">
                <label><strong>Custom Tab Title 1</strong></label>
                <div class="input-box"> <input type="text" name="custom_tab_title1" value="<?= $custom_tab_title1 ?>"></div>
            </div>
            <div class="meta-box-fields">
                <label><strong>Custom Tab Content 1</strong></label>
                <div class="input-box"><?php wp_editor($custom_tab_content1, 'custom_tab_content1'); ?></div>
            </div>
        </div>
        <div class="custom-tabs-holder">
            <div class="meta-box-fields">
                <label><strong>Custom Tab Title 2</strong></label>
                <div class="input-box"> <input type="text" name="custom_tab_title2" value="<?= $custom_tab_title2 ?>"></div>
            </div>
            <div class="meta-box-fields">
                <label><strong>Custom Tab Content 2</strong></label>
                <div class="input-box"><?php wp_editor($custom_tab_content2, 'custom_tab_content2'); ?></div>
            </div>
        </div>
        <div class="custom-tabs-holder">
            <div class="meta-box-fields">
                <label><strong>Custom Tab Title 3</strong></label>
                <div class="input-box"> <input type="text" name="custom_tab_title3" value="<?= $custom_tab_title3 ?>"></div>
            </div>
            <div class="meta-box-fields">
                <label><strong>Custom Tab Content 3</strong></label>
                <div class="input-box"><?php wp_editor($custom_tab_content3, 'custom_tab_content3'); ?></div>
            </div>
        </div>
    </div>
<?php
}



/**
 * @snippet       New Product Tab @ WooCommerce Single Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 8
 * @community     https://businessbloomer.com/club/
 */

add_filter('woocommerce_product_tabs', 'action_woocommerce_product_tabs', 9999);

function action_woocommerce_product_tabs($tabs)
{
    global $post;
    $custom_tab_title1 = get_post_meta($post->ID, 'custom_tab_title1', true);
    $custom_tab_title2 = get_post_meta($post->ID, 'custom_tab_title2', true);
    $custom_tab_title3 = get_post_meta($post->ID, 'custom_tab_title3', true);
    $tech_sheets = carbon_get_post_meta($post->ID, 'tech_sheets');

    if ($custom_tab_title1) {
        $tabs['custom_tab_1'] = array(
            'title' => __($custom_tab_title1, 'woocommerce'), // TAB TITLE
            'priority' => 50, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
            'callback' => 'custom_tab_1_content', // TAB CONTENT CALLBACK
        );
    }

    if ($custom_tab_title2) {
        $tabs['custom_tab_2'] = array(
            'title' => __($custom_tab_title2, 'woocommerce'), // TAB TITLE
            'priority' => 50, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
            'callback' => 'custom_tab_2_content', // TAB CONTENT CALLBACK
        );
    }

    if ($custom_tab_title3 && $custom_tab_title3 != 'Tech Sheet') {
        $tabs['custom_tab_3'] = array(
            'title' => __($custom_tab_title3, 'woocommerce'), // TAB TITLE
            'priority' => 50, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
            'callback' => 'custom_tab_3_content', // TAB CONTENT CALLBACK
        );
    }
    if ($tech_sheets) {
        $tabs['tech_sheet'] = array(
            'title' => __('Tech Sheet', 'woocommerce'), // TAB TITLE
            'priority' => 50, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
            'callback' => 'tech_sheet_content', // TAB CONTENT CALLBACK
        );
    }

    $tabs['bulk_order'] = array(
        'title' => __('Bulk Order Request Form', 'woocommerce'), // TAB TITLE
        'priority' => 50, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        'callback' => 'bulk_order_content', // TAB CONTENT CALLBACK
    );

    $tabs['free_sample'] = array(
        'title' => __('Free Sample', 'woocommerce'), // TAB TITLE
        'priority' => 50, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        'callback' => 'free_sample_content', // TAB CONTENT CALLBACK
    );
    return $tabs;
}

function bulk_order_content()
{
?>
    <div class="bulk-order-form">
        <?= do_shortcode('[gravityform id="2" title="false" ajax="true"]') ?>
    </div>
<?php
}

function free_sample_content()
{
?>
    <div class="free-sample">
        <div class="heading-box">
            <h3>Claim Your Free Sample Today!</h3>
        </div>
        <div class="description-box">
            <p>
                See the quality for yourself. Our samples are free. You’ll just need to cover the postage.
            </p>
        </div>
        <div class="button-box">
            <a href="https://systempak.net/claim-your-free-sample/" class="button">
                Claim Your Sample
            </a>
        </div>
    </div>
<?php
}

function tech_sheet_content()
{
    global $post;
    $tech_sheets = carbon_get_post_meta($post->ID, 'tech_sheets');
    echo '<div class="tech-sheets">';
    foreach ($tech_sheets as $tech_sheet) {
        $tech_sheet_heading = $tech_sheet['tech_sheet_heading'];
        $tech_sheet_file = $tech_sheet['tech_sheet_file'];
        echo '<div>';
        if ($tech_sheet_heading) {
            echo "<strong>$tech_sheet_heading</strong>";
        }
        if ($tech_sheet_file) {
            echo '<a class="download-tech-sheet" target="_blank" href="' . wp_get_attachment_url($tech_sheet_file) . '"> <img src="' . image_dir . 'pdf-techsheet.png"/> </a>';
        }
        echo '</div>';
    }
    echo '</div>';
}

function custom_tab_1_content()
{
    global $post;
    $custom_tab_content1 = get_post_meta($post->ID, 'custom_tab_content1', true);

    echo wpautop($custom_tab_content1);
}


function custom_tab_2_content()
{
    global $post;
    $custom_tab_content2 = get_post_meta($post->ID, 'custom_tab_content2', true);

    echo wpautop($custom_tab_content2);
}


function custom_tab_3_content()
{
    global $post;
    $custom_tab_content3 = get_post_meta($post->ID, 'custom_tab_content3', true);

    echo wpautop($custom_tab_content3);
}


add_action('woocommerce_product_after_variable_attributes', 'variation_fields', 10, 3);

function variation_fields($loop, $variation_data, $variation)
{

    woocommerce_wp_text_input(
        array(
            'id'            => 'quantity_per_box[' . $loop . ']',
            'label'         => 'Quantity Per Box',
            'wrapper_class' => 'form-row',
            'placeholder'   => 'Enter total quantity per box',
            'desc_tip'      => 'true',
            'description'   => 'This will be use to compute for price per unit in the tiered pricing table ',
            'type'          => 'number',
            'value'         => get_post_meta($variation->ID, 'quantity_per_box', true)
        )
    );
}

add_action('woocommerce_save_product_variation', 'variation_save_fields', 10, 2);

function variation_save_fields($variation_id, $loop)
{


    $quantity_per_box = !empty($_POST['quantity_per_box'][$loop]) ? $_POST['quantity_per_box'][$loop] : '';
    update_post_meta($variation_id, 'quantity_per_box', sanitize_textarea_field($quantity_per_box));
}


add_filter('woocommerce_default_catalog_orderby', 'misha_default_catalog_orderby');

function misha_default_catalog_orderby($sort_by)
{
    return 'capacity-asc';
}


// Add checkbox
function action_woocommerce_variation_options($loop, $variation_data, $variation)
{
    $is_checked = get_post_meta($variation->ID, '_enabled', true);

    if ($is_checked) {
        if ($is_checked == 'yes') {
            $is_checked = 'checked';
        } else {
            $is_checked = '';
        }
    } else {
        $is_checked = 'checked';
    }

?>
    <label class="tips" data-tip="<?php esc_attr_e('Uncheck to hide product on the listing', 'woocommerce'); ?>">
        <?php esc_html_e('Enabled', 'woocommerce'); ?>
        <input type="checkbox" class="checkbox variable_checkbox" name="_enabled[<?php echo esc_attr($loop); ?>]" <?php echo $is_checked; ?> />
    </label>
<?php
}
add_action('woocommerce_variation_options', 'action_woocommerce_variation_options', 10, 3);

// Save checkbox
function action_woocommerce_save_product_variation($variation_id, $i)
{
    if (!empty($_POST['_enabled']) && !empty($_POST['_enabled'][$i])) {
        update_post_meta($variation_id, '_enabled', 'yes');
    } else {
        update_post_meta($variation_id, '_enabled', 'no');
    }
}
add_action('woocommerce_save_product_variation', 'action_woocommerce_save_product_variation', 10, 2);


