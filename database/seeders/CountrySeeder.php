<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Country::insert([
            ['iso' => 'AF', 'name' => 'AFGHANISTAN', 'nice_name' => 'AFGHANISTAN', 'iso3' => 'AFG', 'num_code' => '4', 'phone_code' => '93'],
            ['iso' => 'AL', 'name' => 'ALBANIA', 'nice_name' => 'ALBANIA', 'iso3' => 'ALB', 'num_code' => '8', 'phone_code' => '355'],
            ['iso' => 'DZ', 'name' => 'ALGERIA', 'nice_name' => 'ALGERIA', 'iso3' => 'DZA', 'num_code' => '12', 'phone_code' => '213'],
            ['iso' => 'AS', 'name' => 'AMERICAN SAMOA', 'nice_name' => 'AMERICAN SAMOA', 'iso3' => 'ASM', 'num_code' => '16', 'phone_code' => '1684'],
            ['iso' => 'AD', 'name' => 'ANDORRA', 'nice_name' => 'ANDORRA', 'iso3' => 'AND', 'num_code' => '20', 'phone_code' => '376'],
            ['iso' => 'AO', 'name' => 'ANGOLA', 'nice_name' => 'ANGOLA', 'iso3' => 'AGO', 'num_code' => '24', 'phone_code' => '244'],
            ['iso' => 'AI', 'name' => 'ANGUILLA', 'nice_name' => 'ANGUILLA', 'iso3' => 'AIA', 'num_code' => '660', 'phone_code' => '1264'],
            ['iso' => 'AQ', 'name' => 'ANTARCTICA', 'nice_name' => 'ANTARCTICA', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '0'],
            ['iso' => 'AG', 'name' => 'ANTIGUA AND BARBUDA', 'nice_name' => 'ANTIGUA AND BARBUDA', 'iso3' => 'ATG', 'num_code' => '28', 'phone_code' => '1268'],
            ['iso' => 'AR', 'name' => 'ARGENTINA', 'nice_name' => 'ARGENTINA', 'iso3' => 'ARG', 'num_code' => '32', 'phone_code' => '54'],
            ['iso' => 'AM', 'name' => 'ARMENIA', 'nice_name' => 'ARMENIA', 'iso3' => 'ARM', 'num_code' => '51', 'phone_code' => '374'],
            ['iso' => 'AW', 'name' => 'ARUBA', 'nice_name' => 'ARUBA', 'iso3' => 'ABW', 'num_code' => '533', 'phone_code' => '297'],
            ['iso' => 'AU', 'name' => 'AUSTRALIA', 'nice_name' => 'AUSTRALIA', 'iso3' => 'AUS', 'num_code' => '36', 'phone_code' => '61'],
            ['iso' => 'AT', 'name' => 'AUSTRIA', 'nice_name' => 'AUSTRIA', 'iso3' => 'AUT', 'num_code' => '40', 'phone_code' => '43'],
            ['iso' => 'AZ', 'name' => 'AZERBAIJAN', 'nice_name' => 'AZERBAIJAN', 'iso3' => 'AZE', 'num_code' => '31', 'phone_code' => '994'],
            ['iso' => 'BS', 'name' => 'BAHAMAS', 'nice_name' => 'BAHAMAS', 'iso3' => 'BHS', 'num_code' => '44', 'phone_code' => '1242'],
            ['iso' => 'BH', 'name' => 'BAHRAIN', 'nice_name' => 'BAHRAIN', 'iso3' => 'BHR', 'num_code' => '48', 'phone_code' => '973'],
            ['iso' => 'BD', 'name' => 'BANGLADESH', 'nice_name' => 'BANGLADESH', 'iso3' => 'BGD', 'num_code' => '50', 'phone_code' => '880'],
            ['iso' => 'BB', 'name' => 'BARBADOS', 'nice_name' => 'BARBADOS', 'iso3' => 'BRB', 'num_code' => '52', 'phone_code' => '1246'],
            ['iso' => 'BY', 'name' => 'BELARUS', 'nice_name' => 'BELARUS', 'iso3' => 'BLR', 'num_code' => '112', 'phone_code' => '375'],
            ['iso' => 'BE', 'name' => 'BELGIUM', 'nice_name' => 'BELGIUM', 'iso3' => 'BEL', 'num_code' => '56', 'phone_code' => '32'],
            ['iso' => 'BZ', 'name' => 'BELIZE', 'nice_name' => 'BELIZE', 'iso3' => 'BLZ', 'num_code' => '84', 'phone_code' => '501'],
            ['iso' => 'BJ', 'name' => 'BENIN', 'nice_name' => 'BENIN', 'iso3' => 'BEN', 'num_code' => '204', 'phone_code' => '229'],
            ['iso' => 'BM', 'name' => 'BERMUDA', 'nice_name' => 'BERMUDA', 'iso3' => 'BMU', 'num_code' => '60', 'phone_code' => '1441'],
            ['iso' => 'BT', 'name' => 'BHUTAN', 'nice_name' => 'BHUTAN', 'iso3' => 'BTN', 'num_code' => '64', 'phone_code' => '975'],
            ['iso' => 'BO', 'name' => 'BOLIVIA', 'nice_name' => 'BOLIVIA', 'iso3' => 'BOL', 'num_code' => '68', 'phone_code' => '591'],
            ['iso' => 'BA', 'name' => 'BOSNIA AND HERZEGOVINA', 'nice_name' => 'BOSNIA AND HERZEGOVINA', 'iso3' => 'BIH', 'num_code' => '70', 'phone_code' => '387'],
            ['iso' => 'BW', 'name' => 'BOTSWANA', 'nice_name' => 'BOTSWANA', 'iso3' => 'BWA', 'num_code' => '72', 'phone_code' => '267'],
            ['iso' => 'BV', 'name' => 'BOUVET ISLAND', 'nice_name' => 'BOUVET ISLAND', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '0'],
            ['iso' => 'BR', 'name' => 'BRAZIL', 'nice_name' => 'BRAZIL', 'iso3' => 'BRA', 'num_code' => '76', 'phone_code' => '55'],
            ['iso' => 'IO', 'name' => 'BRITISH INDIAN OCEAN TERRITORY', 'nice_name' => 'BRITISH INDIAN OCEAN TERRITORY', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '246'],
            ['iso' => 'BN', 'name' => 'BRUNEI DARUSSALAM', 'nice_name' => 'BRUNEI DARUSSALAM', 'iso3' => 'BRN', 'num_code' => '96', 'phone_code' => '673'],
            ['iso' => 'BG', 'name' => 'BULGARIA', 'nice_name' => 'BULGARIA', 'iso3' => 'BGR', 'num_code' => '100', 'phone_code' => '359'],
            ['iso' => 'BF', 'name' => 'BURKINA FASO', 'nice_name' => 'BURKINA FASO', 'iso3' => 'BFA', 'num_code' => '854', 'phone_code' => '226'],
            ['iso' => 'BI', 'name' => 'BURUNDI', 'nice_name' => 'BURUNDI', 'iso3' => 'BDI', 'num_code' => '108', 'phone_code' => '257'],
            ['iso' => 'KH', 'name' => 'CAMBODIA', 'nice_name' => 'CAMBODIA', 'iso3' => 'KHM', 'num_code' => '116', 'phone_code' => '855'],
            ['iso' => 'CM', 'name' => 'CAMEROON', 'nice_name' => 'CAMEROON', 'iso3' => 'CMR', 'num_code' => '120', 'phone_code' => '237'],
            ['iso' => 'CA', 'name' => 'CANADA', 'nice_name' => 'CANADA', 'iso3' => 'CAN', 'num_code' => '124', 'phone_code' => '1'],
            ['iso' => 'CV', 'name' => 'CAPE VERDE', 'nice_name' => 'CAPE VERDE', 'iso3' => 'CPV', 'num_code' => '132', 'phone_code' => '238'],
            ['iso' => 'KY', 'name' => 'CAYMAN ISLANDS', 'nice_name' => 'CAYMAN ISLANDS', 'iso3' => 'CYM', 'num_code' => '136', 'phone_code' => '1345'],
            ['iso' => 'CF', 'name' => 'CENTRAL AFRICAN REPUBLIC', 'nice_name' => 'CENTRAL AFRICAN REPUBLIC', 'iso3' => 'CAF', 'num_code' => '140', 'phone_code' => '236'],
            ['iso' => 'TD', 'name' => 'CHAD', 'nice_name' => 'CHAD', 'iso3' => 'TCD', 'num_code' => '148', 'phone_code' => '235'],
            ['iso' => 'CL', 'name' => 'CHILE', 'nice_name' => 'CHILE', 'iso3' => 'CHL', 'num_code' => '152', 'phone_code' => '56'],
            ['iso' => 'CN', 'name' => 'CHINA', 'nice_name' => 'CHINA', 'iso3' => 'CHN', 'num_code' => '156', 'phone_code' => '86'],
            ['iso' => 'CX', 'name' => 'CHRISTMAS ISLAND', 'nice_name' => 'CHRISTMAS ISLAND', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '61'],
            ['iso' => 'CC', 'name' => 'COCOS (KEELING) ISLANDS', 'nice_name' => 'COCOS (KEELING) ISLANDS', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '672'],
            ['iso' => 'CO', 'name' => 'COLOMBIA', 'nice_name' => 'COLOMBIA', 'iso3' => 'COL', 'num_code' => '170', 'phone_code' => '57'],
            ['iso' => 'KM', 'name' => 'COMOROS', 'nice_name' => 'COMOROS', 'iso3' => 'COM', 'num_code' => '174', 'phone_code' => '269'],
            ['iso' => 'CG', 'name' => 'CONGO', 'nice_name' => 'CONGO', 'iso3' => 'COG', 'num_code' => '178', 'phone_code' => '242'],
            ['iso' => 'CD', 'name' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'nice_name' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'iso3' => 'COD', 'num_code' => '180', 'phone_code' => '242'],
            ['iso' => 'CK', 'name' => 'COOK ISLANDS', 'nice_name' => 'COOK ISLANDS', 'iso3' => 'COK', 'num_code' => '184', 'phone_code' => '682'],
            ['iso' => 'CR', 'name' => 'COSTA RICA', 'nice_name' => 'COSTA RICA', 'iso3' => 'CRI', 'num_code' => '188', 'phone_code' => '506'],
            ['iso' => 'CI', 'name' => 'COTE D\'IVOIRE', 'nice_name' => 'COTE D\'IVOIRE', 'iso3' => 'CIV', 'num_code' => '384', 'phone_code' => '225'],
            ['iso' => 'HR', 'name' => 'CROATIA', 'nice_name' => 'CROATIA', 'iso3' => 'HRV', 'num_code' => '191', 'phone_code' => '385'],
            ['iso' => 'CU', 'name' => 'CUBA', 'nice_name' => 'CUBA', 'iso3' => 'CUB', 'num_code' => '192', 'phone_code' => '53'],
            ['iso' => 'CY', 'name' => 'CYPRUS', 'nice_name' => 'CYPRUS', 'iso3' => 'CYP', 'num_code' => '196', 'phone_code' => '357'],
            ['iso' => 'CZ', 'name' => 'CZECH REPUBLIC', 'nice_name' => 'CZECH REPUBLIC', 'iso3' => 'CZE', 'num_code' => '203', 'phone_code' => '420'],
            ['iso' => 'DK', 'name' => 'DENMARK', 'nice_name' => 'DENMARK', 'iso3' => 'DNK', 'num_code' => '208', 'phone_code' => '45'],
            ['iso' => 'DJ', 'name' => 'DJIBOUTI', 'nice_name' => 'DJIBOUTI', 'iso3' => 'DJI', 'num_code' => '262', 'phone_code' => '253'],
            ['iso' => 'DM', 'name' => 'DOMINICA', 'nice_name' => 'DOMINICA', 'iso3' => 'DMA', 'num_code' => '212', 'phone_code' => '1767'],
            ['iso' => 'DO', 'name' => 'DOMINICAN REPUBLIC', 'nice_name' => 'DOMINICAN REPUBLIC', 'iso3' => 'DOM', 'num_code' => '214', 'phone_code' => '1809'],
            ['iso' => 'EC', 'name' => 'ECUADOR', 'nice_name' => 'ECUADOR', 'iso3' => 'ECU', 'num_code' => '218', 'phone_code' => '593'],
            ['iso' => 'EG', 'name' => 'EGYPT', 'nice_name' => 'EGYPT', 'iso3' => 'EGY', 'num_code' => '818', 'phone_code' => '20'],
            ['iso' => 'SV', 'name' => 'EL SALVADOR', 'nice_name' => 'EL SALVADOR', 'iso3' => 'SLV', 'num_code' => '222', 'phone_code' => '503'],
            ['iso' => 'GQ', 'name' => 'EQUATORIAL GUINEA', 'nice_name' => 'EQUATORIAL GUINEA', 'iso3' => 'GNQ', 'num_code' => '226', 'phone_code' => '240'],
            ['iso' => 'ER', 'name' => 'ERITREA', 'nice_name' => 'ERITREA', 'iso3' => 'ERI', 'num_code' => '232', 'phone_code' => '291'],
            ['iso' => 'EE', 'name' => 'ESTONIA', 'nice_name' => 'ESTONIA', 'iso3' => 'EST', 'num_code' => '233', 'phone_code' => '372'],
            ['iso' => 'ET', 'name' => 'ETHIOPIA', 'nice_name' => 'ETHIOPIA', 'iso3' => 'ETH', 'num_code' => '231', 'phone_code' => '251'],
            ['iso' => 'FK', 'name' => 'FALKLAND ISLANDS (MALVINAS)', 'nice_name' => 'FALKLAND ISLANDS (MALVINAS)', 'iso3' => 'FLK', 'num_code' => '238', 'phone_code' => '500'],
            ['iso' => 'FO', 'name' => 'FAROE ISLANDS', 'nice_name' => 'FAROE ISLANDS', 'iso3' => 'FRO', 'num_code' => '234', 'phone_code' => '298'],
            ['iso' => 'FJ', 'name' => 'FIJI', 'nice_name' => 'FIJI', 'iso3' => 'FJI', 'num_code' => '242', 'phone_code' => '679'],
            ['iso' => 'FI', 'name' => 'FINLAND', 'nice_name' => 'FINLAND', 'iso3' => 'FIN', 'num_code' => '246', 'phone_code' => '358'],
            ['iso' => 'FR', 'name' => 'FRANCE', 'nice_name' => 'FRANCE', 'iso3' => 'FRA', 'num_code' => '250', 'phone_code' => '33'],
            ['iso' => 'GF', 'name' => 'FRENCH GUIANA', 'nice_name' => 'FRENCH GUIANA', 'iso3' => 'GUF', 'num_code' => '254', 'phone_code' => '594'],
            ['iso' => 'PF', 'name' => 'FRENCH POLYNESIA', 'nice_name' => 'FRENCH POLYNESIA', 'iso3' => 'PYF', 'num_code' => '258', 'phone_code' => '689'],
            ['iso' => 'TF', 'name' => 'FRENCH SOUTHERN TERRITORIES', 'nice_name' => 'FRENCH SOUTHERN TERRITORIES', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '0'],
            ['iso' => 'GA', 'name' => 'GABON', 'nice_name' => 'GABON', 'iso3' => 'GAB', 'num_code' => '266', 'phone_code' => '241'],
            ['iso' => 'GM', 'name' => 'GAMBIA', 'nice_name' => 'GAMBIA', 'iso3' => 'GMB', 'num_code' => '270', 'phone_code' => '220'],
            ['iso' => 'GE', 'name' => 'GEORGIA', 'nice_name' => 'GEORGIA', 'iso3' => 'GEO', 'num_code' => '268', 'phone_code' => '995'],
            ['iso' => 'DE', 'name' => 'GERMANY', 'nice_name' => 'GERMANY', 'iso3' => 'DEU', 'num_code' => '276', 'phone_code' => '49'],
            ['iso' => 'GH', 'name' => 'GHANA', 'nice_name' => 'GHANA', 'iso3' => 'GHA', 'num_code' => '288', 'phone_code' => '233'],
            ['iso' => 'GI', 'name' => 'GIBRALTAR', 'nice_name' => 'GIBRALTAR', 'iso3' => 'GIB', 'num_code' => '292', 'phone_code' => '350'],
            ['iso' => 'GR', 'name' => 'GREECE', 'nice_name' => 'GREECE', 'iso3' => 'GRC', 'num_code' => '300', 'phone_code' => '30'],
            ['iso' => 'GL', 'name' => 'GREENLAND', 'nice_name' => 'GREENLAND', 'iso3' => 'GRL', 'num_code' => '304', 'phone_code' => '299'],
            ['iso' => 'GD', 'name' => 'GRENADA', 'nice_name' => 'GRENADA', 'iso3' => 'GRD', 'num_code' => '308', 'phone_code' => '1473'],
            ['iso' => 'GP', 'name' => 'GUADELOUPE', 'nice_name' => 'GUADELOUPE', 'iso3' => 'GLP', 'num_code' => '312', 'phone_code' => '590'],
            ['iso' => 'GU', 'name' => 'GUAM', 'nice_name' => 'GUAM', 'iso3' => 'GUM', 'num_code' => '316', 'phone_code' => '1671'],
            ['iso' => 'GT', 'name' => 'GUATEMALA', 'nice_name' => 'GUATEMALA', 'iso3' => 'GTM', 'num_code' => '320', 'phone_code' => '502'],
            ['iso' => 'GN', 'name' => 'GUINEA', 'nice_name' => 'GUINEA', 'iso3' => 'GIN', 'num_code' => '324', 'phone_code' => '224'],
            ['iso' => 'GW', 'name' => 'GUINEA-BISSAU', 'nice_name' => 'GUINEA-BISSAU', 'iso3' => 'GNB', 'num_code' => '624', 'phone_code' => '245'],
            ['iso' => 'GY', 'name' => 'GUYANA', 'nice_name' => 'GUYANA', 'iso3' => 'GUY', 'num_code' => '328', 'phone_code' => '592'],
            ['iso' => 'HT', 'name' => 'HAITI', 'nice_name' => 'HAITI', 'iso3' => 'HTI', 'num_code' => '332', 'phone_code' => '509'],
            ['iso' => 'HM', 'name' => 'HEARD ISLAND AND MCDONALD ISLANDS', 'nice_name' => 'HEARD ISLAND AND MCDONALD ISLANDS', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '0'],
            ['iso' => 'VA', 'name' => 'HOLY SEE (VATICAN CITY STATE)', 'nice_name' => 'HOLY SEE (VATICAN CITY STATE)', 'iso3' => 'VAT', 'num_code' => '336', 'phone_code' => '39'],
            ['iso' => 'HN', 'name' => 'HONDURAS', 'nice_name' => 'HONDURAS', 'iso3' => 'HND', 'num_code' => '340', 'phone_code' => '504'],
            ['iso' => 'HK', 'name' => 'HONG KONG', 'nice_name' => 'HONG KONG', 'iso3' => 'HKG', 'num_code' => '344', 'phone_code' => '852'],
            ['iso' => 'HU', 'name' => 'HUNGARY', 'nice_name' => 'HUNGARY', 'iso3' => 'HUN', 'num_code' => '348', 'phone_code' => '36'],
            ['iso' => 'IS', 'name' => 'ICELAND', 'nice_name' => 'ICELAND', 'iso3' => 'ISL', 'num_code' => '352', 'phone_code' => '354'],
            ['iso' => 'IN', 'name' => 'INDIA', 'nice_name' => 'INDIA', 'iso3' => 'IND', 'num_code' => '356', 'phone_code' => '91'],
            ['iso' => 'ID', 'name' => 'INDONESIA', 'nice_name' => 'INDONESIA', 'iso3' => 'IDN', 'num_code' => '360', 'phone_code' => '62'],
            ['iso' => 'IR', 'name' => 'IRAN, ISLAMIC REPUBLIC OF', 'nice_name' => 'IRAN, ISLAMIC REPUBLIC OF', 'iso3' => 'IRN', 'num_code' => '364', 'phone_code' => '98'],
            ['iso' => 'IQ', 'name' => 'IRAQ', 'nice_name' => 'IRAQ', 'iso3' => 'IRQ', 'num_code' => '368', 'phone_code' => '964'],
            ['iso' => 'IE', 'name' => 'IRELAND', 'nice_name' => 'IRELAND', 'iso3' => 'IRL', 'num_code' => '372', 'phone_code' => '353'],
            ['iso' => 'IL', 'name' => 'ISRAEL', 'nice_name' => 'ISRAEL', 'iso3' => 'ISR', 'num_code' => '376', 'phone_code' => '972'],
            ['iso' => 'IT', 'name' => 'ITALY', 'nice_name' => 'ITALY', 'iso3' => 'ITA', 'num_code' => '380', 'phone_code' => '39'],
            ['iso' => 'JM', 'name' => 'JAMAICA', 'nice_name' => 'JAMAICA', 'iso3' => 'JAM', 'num_code' => '388', 'phone_code' => '1876'],
            ['iso' => 'JP', 'name' => 'JAPAN', 'nice_name' => 'JAPAN', 'iso3' => 'JPN', 'num_code' => '392', 'phone_code' => '81'],
            ['iso' => 'JO', 'name' => 'JORDAN', 'nice_name' => 'JORDAN', 'iso3' => 'JOR', 'num_code' => '400', 'phone_code' => '962'],
            ['iso' => 'KZ', 'name' => 'KAZAKHSTAN', 'nice_name' => 'KAZAKHSTAN', 'iso3' => 'KAZ', 'num_code' => '398', 'phone_code' => '7'],
            ['iso' => 'KE', 'name' => 'KENYA', 'nice_name' => 'KENYA', 'iso3' => 'KEN', 'num_code' => '404', 'phone_code' => '254'],
            ['iso' => 'KI', 'name' => 'KIRIBATI', 'nice_name' => 'KIRIBATI', 'iso3' => 'KIR', 'num_code' => '296', 'phone_code' => '686'],
            ['iso' => 'KP', 'name' => 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'nice_name' => 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'iso3' => 'PRK', 'num_code' => '408', 'phone_code' => '850'],
            ['iso' => 'KR', 'name' => 'KOREA, REPUBLIC OF', 'nice_name' => 'KOREA, REPUBLIC OF', 'iso3' => 'KOR', 'num_code' => '410', 'phone_code' => '82'],
            ['iso' => 'KW', 'name' => 'KUWAIT', 'nice_name' => 'KUWAIT', 'iso3' => 'KWT', 'num_code' => '414', 'phone_code' => '965'],
            ['iso' => 'KG', 'name' => 'KYRGYZSTAN', 'nice_name' => 'KYRGYZSTAN', 'iso3' => 'KGZ', 'num_code' => '417', 'phone_code' => '996'],
            ['iso' => 'LA', 'name' => 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'nice_name' => 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'iso3' => 'LAO', 'num_code' => '418', 'phone_code' => '856'],
            ['iso' => 'LV', 'name' => 'LATVIA', 'nice_name' => 'LATVIA', 'iso3' => 'LVA', 'num_code' => '428', 'phone_code' => '371'],
            ['iso' => 'LB', 'name' => 'LEBANON', 'nice_name' => 'LEBANON', 'iso3' => 'LBN', 'num_code' => '422', 'phone_code' => '961'],
            ['iso' => 'LS', 'name' => 'LESOTHO', 'nice_name' => 'LESOTHO', 'iso3' => 'LSO', 'num_code' => '426', 'phone_code' => '266'],
            ['iso' => 'LR', 'name' => 'LIBERIA', 'nice_name' => 'LIBERIA', 'iso3' => 'LBR', 'num_code' => '430', 'phone_code' => '231'],
            ['iso' => 'LY', 'name' => 'LIBYAN ARAB JAMAHIRIYA', 'nice_name' => 'LIBYAN ARAB JAMAHIRIYA', 'iso3' => 'LBY', 'num_code' => '434', 'phone_code' => '218'],
            ['iso' => 'LI', 'name' => 'LIECHTENSTEIN', 'nice_name' => 'LIECHTENSTEIN', 'iso3' => 'LIE', 'num_code' => '438', 'phone_code' => '423'],
            ['iso' => 'LT', 'name' => 'LITHUANIA', 'nice_name' => 'LITHUANIA', 'iso3' => 'LTU', 'num_code' => '440', 'phone_code' => '370'],
            ['iso' => 'LU', 'name' => 'LUXEMBOURG', 'nice_name' => 'LUXEMBOURG', 'iso3' => 'LUX', 'num_code' => '442', 'phone_code' => '352'],
            ['iso' => 'MO', 'name' => 'MACAO', 'nice_name' => 'MACAO', 'iso3' => 'MAC', 'num_code' => '446', 'phone_code' => '853'],
            ['iso' => 'MK', 'name' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'nice_name' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'iso3' => 'MKD', 'num_code' => '807', 'phone_code' => '389'],
            ['iso' => 'MG', 'name' => 'MADAGASCAR', 'nice_name' => 'MADAGASCAR', 'iso3' => 'MDG', 'num_code' => '450', 'phone_code' => '261'],
            ['iso' => 'MW', 'name' => 'MALAWI', 'nice_name' => 'MALAWI', 'iso3' => 'MWI', 'num_code' => '454', 'phone_code' => '265'],
            ['iso' => 'MY', 'name' => 'MALAYSIA', 'nice_name' => 'MALAYSIA', 'iso3' => 'MYS', 'num_code' => '458', 'phone_code' => '60'],
            ['iso' => 'MV', 'name' => 'MALDIVES', 'nice_name' => 'MALDIVES', 'iso3' => 'MDV', 'num_code' => '462', 'phone_code' => '960'],
            ['iso' => 'ML', 'name' => 'MALI', 'nice_name' => 'MALI', 'iso3' => 'MLI', 'num_code' => '466', 'phone_code' => '223'],
            ['iso' => 'MT', 'name' => 'MALTA', 'nice_name' => 'MALTA', 'iso3' => 'MLT', 'num_code' => '470', 'phone_code' => '356'],
            ['iso' => 'MH', 'name' => 'MARSHALL ISLANDS', 'nice_name' => 'MARSHALL ISLANDS', 'iso3' => 'MHL', 'num_code' => '584', 'phone_code' => '692'],
            ['iso' => 'MQ', 'name' => 'MARTINIQUE', 'nice_name' => 'MARTINIQUE', 'iso3' => 'MTQ', 'num_code' => '474', 'phone_code' => '596'],
            ['iso' => 'MR', 'name' => 'MAURITANIA', 'nice_name' => 'MAURITANIA', 'iso3' => 'MRT', 'num_code' => '478', 'phone_code' => '222'],
            ['iso' => 'MU', 'name' => 'MAURITIUS', 'nice_name' => 'MAURITIUS', 'iso3' => 'MUS', 'num_code' => '480', 'phone_code' => '230'],
            ['iso' => 'YT', 'name' => 'MAYOTTE', 'nice_name' => 'MAYOTTE', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '269'],
            ['iso' => 'MX', 'name' => 'MEXICO', 'nice_name' => 'MEXICO', 'iso3' => 'MEX', 'num_code' => '484', 'phone_code' => '52'],
            ['iso' => 'FM', 'name' => 'MICRONESIA, FEDERATED STATES OF', 'nice_name' => 'MICRONESIA, FEDERATED STATES OF', 'iso3' => 'FSM', 'num_code' => '583', 'phone_code' => '691'],
            ['iso' => 'MD', 'name' => 'MOLDOVA, REPUBLIC OF', 'nice_name' => 'MOLDOVA, REPUBLIC OF', 'iso3' => 'MDA', 'num_code' => '498', 'phone_code' => '373'],
            ['iso' => 'MC', 'name' => 'MONACO', 'nice_name' => 'MONACO', 'iso3' => 'MCO', 'num_code' => '492', 'phone_code' => '377'],
            ['iso' => 'MN', 'name' => 'MONGOLIA', 'nice_name' => 'MONGOLIA', 'iso3' => 'MNG', 'num_code' => '496', 'phone_code' => '976'],
            ['iso' => 'MS', 'name' => 'MONTSERRAT', 'nice_name' => 'MONTSERRAT', 'iso3' => 'MSR', 'num_code' => '500', 'phone_code' => '1664'],
            ['iso' => 'MA', 'name' => 'MOROCCO', 'nice_name' => 'MOROCCO', 'iso3' => 'MAR', 'num_code' => '504', 'phone_code' => '212'],
            ['iso' => 'MZ', 'name' => 'MOZAMBIQUE', 'nice_name' => 'MOZAMBIQUE', 'iso3' => 'MOZ', 'num_code' => '508', 'phone_code' => '258'],
            ['iso' => 'MM', 'name' => 'MYANMAR', 'nice_name' => 'MYANMAR', 'iso3' => 'MMR', 'num_code' => '104', 'phone_code' => '95'],
            ['iso' => 'NA', 'name' => 'NAMIBIA', 'nice_name' => 'NAMIBIA', 'iso3' => 'NAM', 'num_code' => '516', 'phone_code' => '264'],
            ['iso' => 'NR', 'name' => 'NAURU', 'nice_name' => 'NAURU', 'iso3' => 'NRU', 'num_code' => '520', 'phone_code' => '674'],
            ['iso' => 'NP', 'name' => 'NEPAL', 'nice_name' => 'NEPAL', 'iso3' => 'NPL', 'num_code' => '524', 'phone_code' => '977'],
            ['iso' => 'NL', 'name' => 'NETHERLANDS', 'nice_name' => 'NETHERLANDS', 'iso3' => 'NLD', 'num_code' => '528', 'phone_code' => '31'],
            ['iso' => 'AN', 'name' => 'NETHERLANDS ANTILLES', 'nice_name' => 'NETHERLANDS ANTILLES', 'iso3' => 'ANT', 'num_code' => '530', 'phone_code' => '599'],
            ['iso' => 'NC', 'name' => 'NEW CALEDONIA', 'nice_name' => 'NEW CALEDONIA', 'iso3' => 'NCL', 'num_code' => '540', 'phone_code' => '687'],
            ['iso' => 'NZ', 'name' => 'NEW ZEALAND', 'nice_name' => 'NEW ZEALAND', 'iso3' => 'NZL', 'num_code' => '554', 'phone_code' => '64'],
            ['iso' => 'NI', 'name' => 'NICARAGUA', 'nice_name' => 'NICARAGUA', 'iso3' => 'NIC', 'num_code' => '558', 'phone_code' => '505'],
            ['iso' => 'NE', 'name' => 'NIGER', 'nice_name' => 'NIGER', 'iso3' => 'NER', 'num_code' => '562', 'phone_code' => '227'],
            ['iso' => 'NG', 'name' => 'NIGERIA', 'nice_name' => 'NIGERIA', 'iso3' => 'NGA', 'num_code' => '566', 'phone_code' => '234'],
            ['iso' => 'NU', 'name' => 'NIUE', 'nice_name' => 'NIUE', 'iso3' => 'NIU', 'num_code' => '570', 'phone_code' => '683'],
            ['iso' => 'NF', 'name' => 'NORFOLK ISLAND', 'nice_name' => 'NORFOLK ISLAND', 'iso3' => 'NFK', 'num_code' => '574', 'phone_code' => '672'],
            ['iso' => 'MP', 'name' => 'NORTHERN MARIANA ISLANDS', 'nice_name' => 'NORTHERN MARIANA ISLANDS', 'iso3' => 'MNP', 'num_code' => '580', 'phone_code' => '1670'],
            ['iso' => 'NO', 'name' => 'NORWAY', 'nice_name' => 'NORWAY', 'iso3' => 'NOR', 'num_code' => '578', 'phone_code' => '47'],
            ['iso' => 'OM', 'name' => 'OMAN', 'nice_name' => 'OMAN', 'iso3' => 'OMN', 'num_code' => '512', 'phone_code' => '968'],
            ['iso' => 'PK', 'name' => 'PAKISTAN', 'nice_name' => 'PAKISTAN', 'iso3' => 'PAK', 'num_code' => '586', 'phone_code' => '92'],
            ['iso' => 'PW', 'name' => 'PALAU', 'nice_name' => 'PALAU', 'iso3' => 'PLW', 'num_code' => '585', 'phone_code' => '680'],
            ['iso' => 'PS', 'name' => 'PALESTINIAN TERRITORY, OCCUPIED', 'nice_name' => 'PALESTINIAN TERRITORY, OCCUPIED', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '970'],
            ['iso' => 'PA', 'name' => 'PANAMA', 'nice_name' => 'PANAMA', 'iso3' => 'PAN', 'num_code' => '591', 'phone_code' => '507'],
            ['iso' => 'PG', 'name' => 'PAPUA NEW GUINEA', 'nice_name' => 'PAPUA NEW GUINEA', 'iso3' => 'PNG', 'num_code' => '598', 'phone_code' => '675'],
            ['iso' => 'PY', 'name' => 'PARAGUAY', 'nice_name' => 'PARAGUAY', 'iso3' => 'PRY', 'num_code' => '600', 'phone_code' => '595'],
            ['iso' => 'PE', 'name' => 'PERU', 'nice_name' => 'PERU', 'iso3' => 'PER', 'num_code' => '604', 'phone_code' => '51'],
            ['iso' => 'PH', 'name' => 'PHILIPPINES', 'nice_name' => 'PHILIPPINES', 'iso3' => 'PHL', 'num_code' => '608', 'phone_code' => '63'],
            ['iso' => 'PN', 'name' => 'PITCAIRN', 'nice_name' => 'PITCAIRN', 'iso3' => 'PCN', 'num_code' => '612', 'phone_code' => '0'],
            ['iso' => 'PL', 'name' => 'POLAND', 'nice_name' => 'POLAND', 'iso3' => 'POL', 'num_code' => '616', 'phone_code' => '48'],
            ['iso' => 'PT', 'name' => 'PORTUGAL', 'nice_name' => 'PORTUGAL', 'iso3' => 'PRT', 'num_code' => '620', 'phone_code' => '351'],
            ['iso' => 'PR', 'name' => 'PUERTO RICO', 'nice_name' => 'PUERTO RICO', 'iso3' => 'PRI', 'num_code' => '630', 'phone_code' => '1787'],
            ['iso' => 'QA', 'name' => 'QATAR', 'nice_name' => 'QATAR', 'iso3' => 'QAT', 'num_code' => '634', 'phone_code' => '974'],
            ['iso' => 'RE', 'name' => 'REUNION', 'nice_name' => 'REUNION', 'iso3' => 'REU', 'num_code' => '638', 'phone_code' => '262'],
            ['iso' => 'RO', 'name' => 'ROMANIA', 'nice_name' => 'ROMANIA', 'iso3' => 'ROM', 'num_code' => '642', 'phone_code' => '40'],
            ['iso' => 'RU', 'name' => 'RUSSIAN FEDERATION', 'nice_name' => 'RUSSIAN FEDERATION', 'iso3' => 'RUS', 'num_code' => '643', 'phone_code' => '70'],
            ['iso' => 'RW', 'name' => 'RWANDA', 'nice_name' => 'RWANDA', 'iso3' => 'RWA', 'num_code' => '646', 'phone_code' => '250'],
            ['iso' => 'SH', 'name' => 'SAINT HELENA', 'nice_name' => 'SAINT HELENA', 'iso3' => 'SHN', 'num_code' => '654', 'phone_code' => '290'],
            ['iso' => 'KN', 'name' => 'SAINT KITTS AND NEVIS', 'nice_name' => 'SAINT KITTS AND NEVIS', 'iso3' => 'KNA', 'num_code' => '659', 'phone_code' => '1869'],
            ['iso' => 'LC', 'name' => 'SAINT LUCIA', 'nice_name' => 'SAINT LUCIA', 'iso3' => 'LCA', 'num_code' => '662', 'phone_code' => '1758'],
            ['iso' => 'PM', 'name' => 'SAINT PIERRE AND MIQUELON', 'nice_name' => 'SAINT PIERRE AND MIQUELON', 'iso3' => 'SPM', 'num_code' => '666', 'phone_code' => '508'],
            ['iso' => 'VC', 'name' => 'SAINT VINCENT AND THE GRENADINES', 'nice_name' => 'SAINT VINCENT AND THE GRENADINES', 'iso3' => 'VCT', 'num_code' => '670', 'phone_code' => '1784'],
            ['iso' => 'WS', 'name' => 'SAMOA', 'nice_name' => 'SAMOA', 'iso3' => 'WSM', 'num_code' => '882', 'phone_code' => '684'],
            ['iso' => 'SM', 'name' => 'SAN MARINO', 'nice_name' => 'SAN MARINO', 'iso3' => 'SMR', 'num_code' => '674', 'phone_code' => '378'],
            ['iso' => 'ST', 'name' => 'SAO TOME AND PRINCIPE', 'nice_name' => 'SAO TOME AND PRINCIPE', 'iso3' => 'STP', 'num_code' => '678', 'phone_code' => '239'],
            ['iso' => 'SA', 'name' => 'SAUDI ARABIA', 'nice_name' => 'SAUDI ARABIA', 'iso3' => 'SAU', 'num_code' => '682', 'phone_code' => '966'],
            ['iso' => 'SN', 'name' => 'SENEGAL', 'nice_name' => 'SENEGAL', 'iso3' => 'SEN', 'num_code' => '686', 'phone_code' => '221'],
            ['iso' => 'CS', 'name' => 'SERBIA AND MONTENEGRO', 'nice_name' => 'SERBIA AND MONTENEGRO', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '381'],
            ['iso' => 'SC', 'name' => 'SEYCHELLES', 'nice_name' => 'SEYCHELLES', 'iso3' => 'SYC', 'num_code' => '690', 'phone_code' => '248'],
            ['iso' => 'SL', 'name' => 'SIERRA LEONE', 'nice_name' => 'SIERRA LEONE', 'iso3' => 'SLE', 'num_code' => '694', 'phone_code' => '232'],
            ['iso' => 'SG', 'name' => 'SINGAPORE', 'nice_name' => 'SINGAPORE', 'iso3' => 'SGP', 'num_code' => '702', 'phone_code' => '65'],
            ['iso' => 'SK', 'name' => 'SLOVAKIA', 'nice_name' => 'SLOVAKIA', 'iso3' => 'SVK', 'num_code' => '703', 'phone_code' => '421'],
            ['iso' => 'SI', 'name' => 'SLOVENIA', 'nice_name' => 'SLOVENIA', 'iso3' => 'SVN', 'num_code' => '705', 'phone_code' => '386'],
            ['iso' => 'SB', 'name' => 'SOLOMON ISLANDS', 'nice_name' => 'SOLOMON ISLANDS', 'iso3' => 'SLB', 'num_code' => '90', 'phone_code' => '677'],
            ['iso' => 'SO', 'name' => 'SOMALIA', 'nice_name' => 'SOMALIA', 'iso3' => 'SOM', 'num_code' => '706', 'phone_code' => '252'],
            ['iso' => 'ZA', 'name' => 'SOUTH AFRICA', 'nice_name' => 'SOUTH AFRICA', 'iso3' => 'ZAF', 'num_code' => '710', 'phone_code' => '27'],
            ['iso' => 'GS', 'name' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'nice_name' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '0'],
            ['iso' => 'ES', 'name' => 'SPAIN', 'nice_name' => 'SPAIN', 'iso3' => 'ESP', 'num_code' => '724', 'phone_code' => '34'],
            ['iso' => 'LK', 'name' => 'SRI LANKA', 'nice_name' => 'SRI LANKA', 'iso3' => 'LKA', 'num_code' => '144', 'phone_code' => '94'],
            ['iso' => 'SD', 'name' => 'SUDAN', 'nice_name' => 'SUDAN', 'iso3' => 'SDN', 'num_code' => '736', 'phone_code' => '249'],
            ['iso' => 'SR', 'name' => 'SURINAME', 'nice_name' => 'SURINAME', 'iso3' => 'SUR', 'num_code' => '740', 'phone_code' => '597'],
            ['iso' => 'SJ', 'name' => 'SVALBARD AND JAN MAYEN', 'nice_name' => 'SVALBARD AND JAN MAYEN', 'iso3' => 'SJM', 'num_code' => '744', 'phone_code' => '47'],
            ['iso' => 'SZ', 'name' => 'SWAZILAND', 'nice_name' => 'SWAZILAND', 'iso3' => 'SWZ', 'num_code' => '748', 'phone_code' => '268'],
            ['iso' => 'SE', 'name' => 'SWEDEN', 'nice_name' => 'SWEDEN', 'iso3' => 'SWE', 'num_code' => '752', 'phone_code' => '46'],
            ['iso' => 'CH', 'name' => 'SWITZERLAND', 'nice_name' => 'SWITZERLAND', 'iso3' => 'CHE', 'num_code' => '756', 'phone_code' => '41'],
            ['iso' => 'SY', 'name' => 'SYRIAN ARAB REPUBLIC', 'nice_name' => 'SYRIAN ARAB REPUBLIC', 'iso3' => 'SYR', 'num_code' => '760', 'phone_code' => '963'],
            ['iso' => 'TW', 'name' => 'TAIWAN, PROVINCE OF CHINA', 'nice_name' => 'TAIWAN, PROVINCE OF CHINA', 'iso3' => 'TWN', 'num_code' => '158', 'phone_code' => '886'],
            ['iso' => 'TJ', 'name' => 'TAJIKISTAN', 'nice_name' => 'TAJIKISTAN', 'iso3' => 'TJK', 'num_code' => '762', 'phone_code' => '992'],
            ['iso' => 'TZ', 'name' => 'TANZANIA, UNITED REPUBLIC OF', 'nice_name' => 'TANZANIA, UNITED REPUBLIC OF', 'iso3' => 'TZA', 'num_code' => '834', 'phone_code' => '255'],
            ['iso' => 'TH', 'name' => 'THAILAND', 'nice_name' => 'THAILAND', 'iso3' => 'THA', 'num_code' => '764', 'phone_code' => '66'],
            ['iso' => 'TL', 'name' => 'TIMOR-LESTE', 'nice_name' => 'TIMOR-LESTE', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '670'],
            ['iso' => 'TG', 'name' => 'TOGO', 'nice_name' => 'TOGO', 'iso3' => 'TGO', 'num_code' => '768', 'phone_code' => '228'],
            ['iso' => 'TK', 'name' => 'TOKELAU', 'nice_name' => 'TOKELAU', 'iso3' => 'TKL', 'num_code' => '772', 'phone_code' => '690'],
            ['iso' => 'TO', 'name' => 'TONGA', 'nice_name' => 'TONGA', 'iso3' => 'TON', 'num_code' => '776', 'phone_code' => '676'],
            ['iso' => 'TT', 'name' => 'TRINIDAD AND TOBAGO', 'nice_name' => 'TRINIDAD AND TOBAGO', 'iso3' => 'TTO', 'num_code' => '780', 'phone_code' => '1868'],
            ['iso' => 'TN', 'name' => 'TUNISIA', 'nice_name' => 'TUNISIA', 'iso3' => 'TUN', 'num_code' => '788', 'phone_code' => '216'],
            ['iso' => 'TR', 'name' => 'TURKEY', 'nice_name' => 'TURKEY', 'iso3' => 'TUR', 'num_code' => '792', 'phone_code' => '90'],
            ['iso' => 'TM', 'name' => 'TURKMENISTAN', 'nice_name' => 'TURKMENISTAN', 'iso3' => 'TKM', 'num_code' => '795', 'phone_code' => '7370'],
            ['iso' => 'TC', 'name' => 'TURKS AND CAICOS ISLANDS', 'nice_name' => 'TURKS AND CAICOS ISLANDS', 'iso3' => 'TCA', 'num_code' => '796', 'phone_code' => '1649'],
            ['iso' => 'TV', 'name' => 'TUVALU', 'nice_name' => 'TUVALU', 'iso3' => 'TUV', 'num_code' => '798', 'phone_code' => '688'],
            ['iso' => 'UG', 'name' => 'UGANDA', 'nice_name' => 'UGANDA', 'iso3' => 'UGA', 'num_code' => '800', 'phone_code' => '256'],
            ['iso' => 'UA', 'name' => 'UKRAINE', 'nice_name' => 'UKRAINE', 'iso3' => 'UKR', 'num_code' => '804', 'phone_code' => '380'],
            ['iso' => 'AE', 'name' => 'UNITED ARAB EMIRATES', 'nice_name' => 'UNITED ARAB EMIRATES', 'iso3' => 'ARE', 'num_code' => '784', 'phone_code' => '971'],
            ['iso' => 'GB', 'name' => 'UNITED KINGDOM', 'nice_name' => 'UNITED KINGDOM', 'iso3' => 'GBR', 'num_code' => '826', 'phone_code' => '44'],
            ['iso' => 'US', 'name' => 'UNITED STATES', 'nice_name' => 'UNITED STATES', 'iso3' => 'USA', 'num_code' => '840', 'phone_code' => '1'],
            ['iso' => 'UM', 'name' => 'UNITED STATES MINOR OUTLYING ISLANDS', 'nice_name' => 'UNITED STATES MINOR OUTLYING ISLANDS', 'iso3' =>  NULL, 'num_code' =>  NULL, 'phone_code' => '1'],
            ['iso' => 'UY', 'name' => 'URUGUAY', 'nice_name' => 'URUGUAY', 'iso3' => 'URY', 'num_code' => '858', 'phone_code' => '598'],
            ['iso' => 'UZ', 'name' => 'UZBEKISTAN', 'nice_name' => 'UZBEKISTAN', 'iso3' => 'UZB', 'num_code' => '860', 'phone_code' => '998'],
            ['iso' => 'VU', 'name' => 'VANUATU', 'nice_name' => 'VANUATU', 'iso3' => 'VUT', 'num_code' => '548', 'phone_code' => '678'],
            ['iso' => 'VE', 'name' => 'VENEZUELA', 'nice_name' => 'VENEZUELA', 'iso3' => 'VEN', 'num_code' => '862', 'phone_code' => '58'],
            ['iso' => 'VN', 'name' => 'VIET NAM', 'nice_name' => 'VIET NAM', 'iso3' => 'VNM', 'num_code' => '704', 'phone_code' => '84'],
            ['iso' => 'VG', 'name' => 'VIRGIN ISLANDS, BRITISH', 'nice_name' => 'VIRGIN ISLANDS, BRITISH', 'iso3' => 'VGB', 'num_code' => '92', 'phone_code' => '1284'],
            ['iso' => 'VI', 'name' => 'VIRGIN ISLANDS, U.S.', 'nice_name' => 'VIRGIN ISLANDS, U.S.', 'iso3' => 'VIR', 'num_code' => '850', 'phone_code' => '1340'],
            ['iso' => 'WF', 'name' => 'WALLIS AND FUTUNA', 'nice_name' => 'WALLIS AND FUTUNA', 'iso3' => 'WLF', 'num_code' => '876', 'phone_code' => '681'],
            ['iso' => 'EH', 'name' => 'WESTERN SAHARA', 'nice_name' => 'WESTERN SAHARA', 'iso3' => 'ESH', 'num_code' => '732', 'phone_code' => '212'],
            ['iso' => 'YE', 'name' => 'YEMEN', 'nice_name' => 'YEMEN', 'iso3' => 'YEM', 'num_code' => '887', 'phone_code' => '967'],
            ['iso' => 'ZM', 'name' => 'ZAMBIA', 'nice_name' => 'ZAMBIA', 'iso3' => 'ZMB', 'num_code' => '894', 'phone_code' => '260'],
            ['iso' => 'ZW', 'name' => 'ZIMBABWE', 'nice_name' => 'ZIMBABWE', 'iso3' => 'ZWE', 'num_code' => '716', 'phone_code' => '263']
        ]);
    }
}
