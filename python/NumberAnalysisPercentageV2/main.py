import pandas as pd
import ipywidgets as widgets
from IPython.display import display

# Define the datasets
dataSG = {'Country': [''], 'DrawDate': ['20-Jul-24'], 'Number1': [9926], 'Number2': [3958], 'Number3': [647], 'Number4': [361], 'Number5': [1193], 'Number6': [1542], 'Number7': [3528], 'Number8': [4019], 'Number9': [5977], 'Number10': [6900], 'Number11': [7896], 'Number12': [9244], 'Number13': [9303], 'Number14': [103], 'Number15': [426], 'Number16': [2159], 'Number17': [5016, 2486, 2736, 1367, 1274, 2677, 3092, 1133, 3763, 4775, 5519, 5913, 3784, 3823, 4022, 1164, 2795, 3005, 2831, 4219, 6019], 'Number18': [5611, 2771, 2795, 1745, 2620, 3915, 3939, 1335, 4858, 5163, 5997, 6562, 4421, 4621, 4728, 1535, 5064, 3431, 5154, 4348, 6131], 'Number19': [5957, 4028, 3493, 2595, 4162, 6471, 6378, 1954, 6826, 7439, 6151, 6714, 7860, 5572, 6441, 5178, 6771, 4524, 8372, 4917, 6947], 'Number20': [7556, 4611, 3692, 2670, 8092, 7435, 6651, 4422, 8009, 8231, 6399, 7327, 8421, 5809, 7112, 5704, 6990, 6723, 8499, 6672, 7663], 'Number21': [7949, 7027, 4239, 5061, 9548, 7556, 6820, 5737, 8273, 8322, 7527, 7660, 9528, 6745, 8268, 7051, 7223, 8508, 8783, 7791, 7988], 'Number22': [9284, 8413, 6474, 6022, 9651, 8226, 6981, 6307, 9704, 8349, 9446, 8364, 9871, 9778, 8875, 7453, 9625, 8592, 8853, 9089, 8314], 'Number23': [9464, 9333, 7305, 8536, 9737, 8844, 9019, 9723, 9985, 8857, 9747, 9185, 9953, 9976, 8927, 9553, 9719, 9812, 9448, 9613, 9976]}

dataMY = {'Country': [''], 'DrawDate': ['20-Jul-24'], 'Number1': [9926], 'Number2': [3958], 'Number3': [647], 'Number4': [361], 'Number5': [1193], 'Number6': [1542], 'Number7': [3528], 'Number8': [4019], 'Number9': [5977], 'Number10': [6900], 'Number11': [7896], 'Number12': [9244], 'Number13': [9303], 'Number14': [103], 'Number15': [426], 'Number16': [2159], 'Number17': [5016], 'Number18': [5611], 'Number19': [5957], 'Number20': [7556], 'Number21': [7949], 'Number22': [9284], 'Number23': [9464]}

# Initialize global variables
df = pd.DataFrame(dataSG)
digit_counts = None
total_numbers = 0

# Function to create DataFrame and count digit occurrences
def count_digit_occurrences(df):
    counts = {
        'thousands': [0] * 10,
        'hundreds': [0] * 10,
        'tens': [0] * 10,
        'units': [0] * 10
    }

    for col in df.columns[2:]:
        for number in df[col]:
            str_num = str(number).zfill(4)
            counts['thousands'][int(str_num[0])] += 1
            counts['hundreds'][int(str_num[1])] += 1
            counts['tens'][int(str_num[2])] += 1
            counts['units'][int(str_num[3])] += 1

    return counts

# Function to calculate weighted probability
def calculate_weighted_probability(number, digit_counts, total_numbers):
    str_num = str(number).zfill(4)
    thousands_prob = digit_counts['thousands'][int(str_num[0])] / total_numbers
    hundreds_prob = digit_counts['hundreds'][int(str_num[1])] / total_numbers
    tens_prob = digit_counts['tens'][int(str_num[2])] / total_numbers
    units_prob = digit_counts['units'][int(str_num[3])] / total_numbers

    weighted_prob = thousands_prob * hundreds_prob * tens_prob * units_prob * 100
    return weighted_prob

# Function to update the DataFrame and digit counts based on dropdown selection
def update_data(country):
    global df, digit_counts, total_numbers

    if country == 'Singapore':
        df = pd.DataFrame(dataSG)
    elif country == 'Malaysia':
        df = pd.DataFrame(dataMY)

    digit_counts = count_digit_occurrences(df)
    total_numbers = df.shape[0] * (df.shape[1] - 2)
    print(f"Data for {country} selected.")

    # Update the user input widget
    display_input()

# Function to handle user input and calculate probability
def calculate_probability(number):
    try:
        user_number = int(number)
        if len(str(user_number)) != 4:
            raise ValueError
    except ValueError:
        result_label.value = "Invalid input. Please enter a valid 4-digit number."
        return

    weighted_probability = calculate_weighted_probability(user_number, digit_counts, total_numbers)
    result_label.value = f"The weighted percentage chance of {user_number} being picked is: {weighted_probability:.6f}%"

# Function to create input widgets
def display_input():
    global result_label

    number_input = widgets.Text(
        description='Number:',
        value='0000',
        placeholder='Enter a 4-digit number'
    )
    submit_button = widgets.Button(description='Calculate')

    def on_button_click(b):
        calculate_probability(number_input.value)

    submit_button.on_click(on_button_click)
    result_label = widgets.Label()

    display(number_input, submit_button, result_label)

# Create widgets for country selection and initialize data
country_dropdown = widgets.Dropdown(
    options=['Singapore', 'Malaysia'],
    value='Singapore',
    description='Country:',
    disabled=False
)

# Attach function to dropdown
country_dropdown.observe(lambda change: update_data(change.new), names='value')

# Display widgets
display(country_dropdown)
update_data('Singapore')  # Initialize with default country
