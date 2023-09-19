from itertools import permutations

def generate_permutations(input_number):
    # Convert the input number to a string to iterate through its digits
    input_str = str(input_number)

    # Generate all permutations of the digits
    permuted_digits = permutations(input_str)

    # Convert the permutations back to integers and filter out duplicates
    unique_permutations = set(int(''.join(p)) for p in permuted_digits)

    return sorted(list(unique_permutations))

if __name__ == "__main__":
    input_number = input("Enter a 4-digit number: ")
    
    if len(input_number) != 4 or not input_number.isdigit():
        print("Invalid input. Please enter a 4-digit number.")
    else:
        permutations_list = generate_permutations(input_number)
        
        if permutations_list:
            print("Permutations of", input_number, "are:", permutations_list)
        else:
            print("No unique permutations found for", input_number)
