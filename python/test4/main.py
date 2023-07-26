import time

def introduction():
    print("Welcome to the Text Adventure Game!")
    time.sleep(1)
    print("You are standing in front of a mysterious cave.")
    time.sleep(1)
    print("Your mission is to explore the cave and find the hidden treasure.")
    time.sleep(1)
    print("Be cautious, as danger may lurk in the darkness...")
    time.sleep(1)

def cave():
    print("\nYou enter the cave.")
    time.sleep(1)
    print("It's dark and damp, and you can hear strange noises echoing.")
    time.sleep(1)

    while True:
        choice = input("Do you want to go 'left' or 'right'? ").lower()
        if choice == "left":
            treasure_chamber()
            break
        elif choice == "right":
            print("You stumble upon a group of bats. They startle you and you run back.")
        else:
            print("Invalid choice. Please choose 'left' or 'right'.")

def treasure_chamber():
    print("\nYou find yourself in a mysterious treasure chamber.")
    time.sleep(1)
    print("There are three chests in front of you.")
    time.sleep(1)

    while True:
        choice = input("Which chest do you want to open? '1', '2', or '3'? ")
        if choice == "1":
            print("Oh no! A trap! A giant boulder rolls towards you.")
            time.sleep(1)
            print("You couldn't escape in time. Game over!")
            break
        elif choice == "2":
            print("Congratulations! You found the treasure! You win!")
            break
        elif choice == "3":
            print("A swarm of angry bees fly out and chase you away.")
        else:
            print("Invalid choice. Please choose '1', '2', or '3'.")

if __name__ == "__main__":
    introduction()
    cave()
