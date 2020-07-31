<div class="wrap">
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="numberposts">Number of Posts</label>
            </th>
            <th scope="row">
                <select name="numberposts" id="numberposts">
                    <option disabled="true" selected>Select</option> 
                    <?php 
                    for ( $i = 1; $i <= $total_post; ++ $i ): 
                        $selected = '';
                        if ( $i == $number_posts ):
                            $selected = 'selected';
                        endif; 
                        printf( '<option value=%d %s>%d</option>', $i, $selected, $i );
                    endfor;
                    ?>
                </select>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label for="order">Select Order</label>
            </th>
            <th scope="row">
                <select name="order" id="order">
                    <option disabled="true" selected>Order</option>
                    <?php foreach ( $orders as $order_key => $value ): 
                            $selected = '';
                            if ( $value == $order ):
                                $selected = 'selected';
                            endif;
                            printf( '<option value=%s %s>%s</option>', $value, $selected, $order_key );
                        endforeach;
                    ?>
                </select>
            </th>
        </tr>
        <tr>
        <?php if ( ! is_null( $terms ) ): ?>
            <th scope="row">
                <label for="category">Category</label>
            </th>
            <th scope="row">
            <?php 
                foreach ( $terms as $term ): 
                    $checked = '';
                    if ( in_array( $term->term_id, $categories ) ):
                        $checked = 'checked';
                    endif;
                    printf( '<input type="checkbox" name="category[]" id="category" value=%d %s />%s<br/>', $term->term_id, $checked, $term->name );
                endforeach;
             ?>
            </th>
            <?php endif; ?>                
        </tr>
    </table>
</div>