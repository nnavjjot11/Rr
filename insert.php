<?php 
 include 'connection.php';

 $insert = "
INSERT INTO `products` (`id`, `name`, `price`, `product_detail`, `image`) VALUES
(2, 'Butter Chicken', '20', 'Dish, originating in the Indian subcontinent, of chicken in a mildly spiced tomato sauce. It is also known as murgh mahal', '9.png'),
(3, 'Channa Masala', '30', 'Chickpeas of the Chana type in tomato based sauce.', '0.jpg'),
(4, 'Samosa', '20', 'Normally served as an entree or appetiser. Potatoes, onions, peas, coriander, and lentils, may be served with a mint or tamarind sauce', '0.png'),
(5, 'Fish Tikka ', '30', 'Powdered turmeric, salt, Mustard oil, White Onion, Hot water, Sugar', '1-1-330x300.png'),
(6, 'Aloo tikki', '15', 'Patties of potato mixed with some vegetables fried', '2.png'),
(7, 'Biryani', '25', 'Mixed rice dish, optional spices, optional vegetables, meats or seafood. Can be served with plain yogurt.', '3.png'),
(8, 'Dal makhani', '30', 'A main course with lentils', '3-1-330x300.jpg'),
(9, 'Dum aloo', '20', 'Potatoes cooked in curry', '4-330x300.jpg'),
(10, 'Jalebi', '15', 'A bigger form of jalebi', '5.png'),
(11, 'Kheer ', '25', 'Rice cooked with milk and dry fruits', '7.jpg'),
(12, 'Kofta', '20', 'Gram flour balls fried with vegetables. Gram flour, veggies, rolled into balls with gram flour and fried in oil and then cooked with curry.', '6.png'),
(13, 'Makki ki roti, sarson ka saag', '20', 'Creamed sarson mustard leaves, with heavily buttered roti made from corn flour. North Indian winter favorite.', '10.jpg'),
(14, 'Mixed vegetable ', '30', 'mixed vegetables, slow cooked with a tomato sauce added.', '9-330x300.jpg'),
(15, 'Moong dal ki Lapsi', '35', 'a dish made with yellow lentils, milk, sugar, and nuts', '15-330x300.jpg'),
(16, 'Navrattan korma', '20', 'Vegetables, Nuts, Paneer Cheese in a tomato cream sauce', '14-330x300.jpg'),
(17, 'Pani puri', '30', 'a typical Indian tadka', '1.png'),
(18, 'Paratha', '20', 'flatbread native to the Indian subcontinent, prevalent throughout the modern-day nations of India', '12-330x300.jpg'),
(19, 'Rajma ', '15', 'Main. Kidney beans & assorted spices.', '10-330x300.jpg');


 ";
 $result = mysqli_query($conn, $insert);
 if ($result) {
 	echo 'inserted';
 }
?>