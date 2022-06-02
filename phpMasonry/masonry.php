<?php
// get images and set counters
$counter = 0;
$images = get_field('rooms-gallery');
$totalAmount = count($images);
$current = 1;
if ($images) : ?>
    <div class="container mt-5 text-muted px-0 text-center">
        <h2 class="section-h3 mb-5">Räumlichkeiten</h2>
        <hr class="section-hr mx-auto mb-5">
        <p class="mx-auto mb-5" id="gallery-subtitle">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
        <div class="mt-5 d-grid gallery">
            <?php foreach ($images as $image) :
                // iterate through images and style them in set layout (one row, 2 cols; one row, 2 cols with 2 rows each)
                switch ($counter):
                    case 0: ?>
                        <!-- 1st row -->
                        <div class="row">
                            <!-- 1st row, 1st col -->
                            <div class="col col-6 gallery-box">
                                <div class="filler">
                                    <img class="header-img rounded" src="<?php echo esc_url($image['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                </div>
                            </div>
                            <?php
                            // check if it reached the end of the loop, if yes then close all divs that would else remain open
                            if ($current >= $totalAmount) {
                                echo "</div>";
                            }
                            break;
                        case 1:
                            ?>
                            <!-- 1st row, 2nd col -->
                            <div class="col col-6 gallery-box">
                                <div class="filler">
                                    <img class="header-img rounded" src="<?php echo esc_url($image['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                </div>
                            </div>
                        </div>
                    <?php break;
                        case 2:
                    ?>
                        <!-- 2nd row -->
                        <div class="row">
                            <!-- 2nd row, 1st col -->
                            <div class="col col-7">
                                <!-- 2nd row, 1st col, 1st row -->
                                <div class="row gallery-row">
                                    <div class="col col-12 gallery-box">
                                        <img class="header-img rounded" src="<?php echo esc_url($image['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </div>
                                </div>
                                <?php
                                // check if it reached the end of the loop, if yes then close all divs that would else remain open
                                if ($current >= $totalAmount) {
                                    echo "</div></div>";
                                }
                                break;
                            case 3:
                                ?>
                                <!-- 2nd row, 1st col, 2nd row -->
                                <div class="row gallery-row">
                                    <div class="col col-12 gallery-box">
                                        <img class="header-img rounded" src="<?php echo esc_url($image['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php
                                // check if it reached the end of the loop, if yes then close all divs that would else remain open
                                if ($current >= $totalAmount) {
                                    echo "</div>";
                                }
                                break;
                            case 4:
                            ?>
                            <!-- 2nd row, 2nd col -->
                            <div class="col col-5">
                                <!-- 2nd row, 2nd col, 1st row -->
                                <div class="row gallery-row-2">
                                    <div class="col col-12 gallery-box">
                                        <img class="header-img rounded" src="<?php echo esc_url($image['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </div>
                                </div>
                                <?php
                                // check if it reached the end of the loop, if yes then close all divs that would else remain open
                                if ($current >= $totalAmount) {
                                    echo "</div></div>";
                                }
                                break;
                            case 5:
                                ?>
                                <!-- 2nd row, 2nd col, 2nd row -->
                                <div class="row gallery-row-1">
                                    <div class="col col-12 gallery-box">
                                        <img class="header-img rounded" src="<?php echo esc_url($image['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php endswitch;
                        // update counter and current
                        $counter++;
                        if ($counter >= 6) {
                            $counter = 0;
                        }
                        $current++;
                    endforeach; ?>
        </div>
    </div>
<?php endif; ?>